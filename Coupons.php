<?php

namespace Kodbazis;

use mysqli;
use Kodbazis\Generated\Repository\Feedback\SqlLister;
use Kodbazis\Generated\Request;
use Kodbazis\Mailer\Mailer;
use Twig\Environment;
use Twig\Extra\Intl\IntlExtension;

class Coupons
{

    public static function redirectToCouponList(Request $request) {
        header("Location: /admin/kuponok");
    }

    public static function enqueueCouponEmailsForSubscriber($conn, $twig) {
        return function (Request $request) use ($conn, $twig) {

            $twig->addExtension(new IntlExtension());
    
            $subscriberId = $request->vars['subscriberId'];
    
            $coupons = fetchAll($conn->query(
                'SELECT 
                *,
                coupons.id AS couponId,
                coupons.discount AS couponDiscount
                 FROM coupons 
                INNER JOIN courses ON courses.id = coupons.courseId
                WHERE 
                    issuedTo = ' . $subscriberId . ' AND
                    validUntil > UNIX_TIMESTAMP() AND
                    redeemedBy IS NULL AND
                    mailedAt IS NULL
            '
            ));
    
            if (!count($coupons)) {
                // header("Location: /admin/kuponok");
                return;
            }
    
            $subscribers = fetchAll($conn->query(
                'SELECT * FROM subscribers WHERE 
                    id = ' . $subscriberId . ' AND 
                    isUnsubscribed != 1
                '
            ));
            if (!count($subscribers)) {
                // header("Location: /admin/kuponok");
                return;
            }
    
            $discountedPrice = function ($price, $discount) {
                $multiplier = (100 - $discount) / 100;
                $x = $price * $multiplier;
                return round($x / 10) * 10;
            };
    
            $ref = uniqid();
    
            $msg = $twig->render('coupon-email2.twig', [
                'subscriberId' => $subscriberId,
                'siteUrl' => Router::siteUrl(),
                'coupons' =>  array_map(function ($c) use ($discountedPrice) {
                    $c['discountedPrice'] = $discountedPrice($c['price'], $c['couponDiscount']);
                    return $c;
                }, $coupons),
                'ref' => $ref,
            ]);
    
            PublicSite::enqueueEmail(
                $subscribers[0]['email'],
                'Sikeres vásárlás + Ajándék',
                $msg,
                $conn
            );
            
            foreach ($coupons as $coupon) {
                $conn->query(
                    "UPDATE coupons SET 
                    `mailedAt` = " . time() . ",
                    `ref` = '" . $ref . "' 
                    WHERE id = " . $coupon['couponId']
                );
            }
        };
    }

    public static function issueCouponsForSubscriber($conn, $twig) {
        return function (Request $request) use ($conn, $twig) {
            $subscriberId = $request->vars['subscriberId'];
            $courses = fetchAll($conn->query('SELECT * FROM courses'));
            $coursesWithoutIssuedCoupons = getCoursesWithoutIssuedCoupons($conn, $courses, $subscriberId);

            $now = time();
            // $days = date('U', strtotime('+5 day', $now));
            $days = date('U', strtotime('+1 week', $now));
            foreach ($coursesWithoutIssuedCoupons as $course) {
                $conn->query(
                    "INSERT INTO `coupons` 
                    (`courseId`, `issuedTo`, `discount`, `code`, `validUntil`, `createdAt`) 
                    VALUES (
                        '" . $course['id'] . "', 
                        '" . $request->vars['subscriberId'] . "', 
                        '" . $request->body['discount'] . "', 
                        '" . uniqId($course['id']) . "', 
                        '" . $days . "',
                        '" . $now . "'
                    );"
                );
            }
        };
    }
    
    public static function getRoutes(Pipeline $r, mysqli $conn, Environment $twig)
    {
        
        $r->post(
            '/admin/api/issueCoupons/{subscriberId}',
            [Auth::class, 'validate'],
            [Coupons::class, 'redirectToCouponList'],
            self::issueCouponsForSubscriber($conn, $twig),   
        );

        $r->post(
            '/admin/api/sendCouponMails/{subscriberId}',
            [Auth::class, 'validate'],
            self::enqueueCouponEmailsForSubscriber($conn, $twig),
            [Coupons::class, 'redirectToCouponList']
        );

        $r->get(
            '/admin/kuponok',
            [Auth::class, 'validate'],
            function (Request $request) use ($conn, $twig) {

                $subscribers = fetchAll($conn->query('SELECT * FROM subscribers WHERE isVerified = 1 ORDER BY createdAt DESC'));
                $courses = fetchAll($conn->query('SELECT * FROM courses'));

                // attach all coupons
                foreach ($subscribers as $i => $subscriber) {
                    $coupons = fetchAll(
                        $conn->query(
                            'SELECT * FROM coupons WHERE issuedTo = ' . $subscriber['id']
                        )
                    );
                    $subscribers[$i]['coupons'] = array_map(function ($coupon) {
                        $coupon['isValid'] = time() < ((int)$coupon['validUntil']);
                        return $coupon;
                    }, $coupons);
                }


                // attach courseIds, areCouponsIssuable, isMailingAvailable
                foreach ($subscribers as $i => $subscriber) {
                    $subscriberCourses = fetchAll(
                        $conn->query(
                            'SELECT * FROM subscriberCourses WHERE subscriberId = ' . $subscriber['id'] . ' AND isPayed = 1'
                        )
                    );
                    $subscribers[$i]['courses'] = array_map(function ($subscriberCourse) use ($conn) {
                        $coupons = fetchAll($conn->query(
                            'SELECT * FROM coupons WHERE 
                            courseId = ' . $subscriberCourse['courseId'] . ' AND
                            redeemedBy = ' . $subscriberCourse['subscriberId'] . '
                        '
                        ));

                        return [
                            'id' => $subscriberCourse['courseId'],
                            'isBoughtWithCoupon' => count($coupons) > 0
                        ];
                    }, $subscriberCourses);

                    $coursesWithoutIssuedCoupons = getCoursesWithoutIssuedCoupons($conn, $courses, $subscriber['id']);

                    $subscribers[$i]['areCouponsIssuable'] = count($coursesWithoutIssuedCoupons) > 0;
                    $subscribers[$i]['isMailingAvailable'] = array_reduce($subscriber['coupons'], fn ($acc, $cr) => $acc || !$cr['mailedAt'], false);
                }


                header("Content-Type: text/html");
                $twig->display('dashboard.twig', [
                    'innerTemplate' => $twig->render('coupons.twig', [
                        'subscribers' => $subscribers
                    ]),
                    'activePath' => '/admin/kuponok',
                    'path' => $request->path,
                    'query' => $request->query,
                ]);
            }
        );

        $r->get(
            '/admin/get-active-sessions',
            [Auth::class, 'validate'],
            function (Request $request) use ($conn, $twig) {

                $allSessions = [];
                $sessionNames = scandir(session_save_path());

                foreach ($sessionNames as $sessionName) {
                    $sessionName = str_replace("sess_", "", $sessionName);
                    //This skips temp files that aren't sessions
                    if (strpos($sessionName, ".") === false) {
                        session_id($sessionName);
                        session_start();
                        $allSessions[$sessionName] = $_SESSION;
                        session_abort();
                    }
                }


                echo '<pre>';
                var_dump($allSessions);
            }
        );
    }
}

function getCoursesWithoutIssuedCoupons($conn, $courses, $subscriberId)
{
    $subscriberCourses = fetchAll($conn->query('SELECT * FROM subscriberCourses WHERE subscriberId = ' . $subscriberId));
    $alreadyBoughtCourseIds = array_map(fn ($sc) => $sc['courseId'], $subscriberCourses);
    $notBoughtCourses = array_filter($courses, fn ($course) => !in_array($course['id'], $alreadyBoughtCourseIds));

    return array_filter($notBoughtCourses, function ($course) use ($conn, $subscriberId) {
        $coupons = fetchAll($conn->query(
            'SELECT * FROM coupons WHERE 
            courseId = ' . $course['id'] . ' AND
            issuedTo = ' . $subscriberId . ' AND
            validUntil > UNIX_TIMESTAMP()
        '
        ));
        return count($coupons) === 0;
    });
}

function fetchAll($res)
{
    $ret = [];
    while ($row = $res->fetch_assoc()) {
        $ret[] = $row;
    }
    return $ret;
}
