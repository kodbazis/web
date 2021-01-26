<?php

namespace Kodbazis;

use Kodbazis\Generated\Listing\Clause;
use Kodbazis\Generated\Listing\OrderBy;
use Kodbazis\Generated\Listing\Query;
use mysqli;
use Twig\Environment;
use Kodbazis\Generated\Repository\SubscriberCourse\SqlPatcher as SubscriberCoursePatcher;
use Kodbazis\Generated\Repository\SubscriberCourse\SqlLister as SubscriberCourseLister;
use Kodbazis\Generated\Repository\SubscriberCourse\SqlDeleter as SubscriberCourseDeleter;
use Kodbazis\Generated\Repository\Course\SqlByIdGetter as CourseById;
use Kodbazis\Generated\Repository\Subscriber\SqlByIdGetter as SubscriberById;
use Kodbazis\Generated\Request;
use Kodbazis\Generated\SubscriberCourse\Patch\PatchedSubscriberCourse;

class PaymentRoutes
{

    public static function getPaymentUrl($course, $subscriberCourse, $subscriber, $conn)
    {
        //Import config data
        require_once 'simplepay/config.php';

        //Import SimplePayment class
        require_once 'simplepay/SimplePayV21.php';

        $trx = new \SimplePayStart;

        $trx->addData('currency', 'HUF');
        $trx->addConfig($config);

        //ORDER PRICE/TOTAL
        //-----------------------------------------------------------------------------------------

        if ($course->getDiscount()) {
            $trx->addData('discount', $course->getPrice() - getDiscountedPrice($course));
        }

        $trx->addItems(
            array(
                'ref' => $subscriberCourse->getId(),
                'title' => $course->getInvoiceTitle(),
                'description' => $course->getDescription(),
                'amount' => '1',
                'price' => $course->getPrice(),
                'tax' => '0',
            )
        );
        //ORDER ITEMS
        //-----------------------------------------------------------------------------------------


        // OPTIONAL DATA INPUT ON PAYMENT PAGE
        //-----------------------------------------------------------------------------------------
        //$trx->addData('maySelectEmail', true);
        //$trx->addData('maySelectInvoice', true);
        //$trx->addData('maySelectDelivery', ['HU']);


        // SHIPPING COST
        //-----------------------------------------------------------------------------------------
        //$trx->addData('shippingCost', 20);


        // DISCOUNT
        //-----------------------------------------------------------------------------------------
        //$trx->addData('discount', 10);


        // ORDER REFERENCE NUMBER
        // uniq oreder reference number in the merchant system
        //-----------------------------------------------------------------------------------------
        $orderRef = str_replace(array('.', ':', '/'), "", @$_SERVER['SERVER_ADDR']) . @date("U", time()) . rand(1000, 9999);
        $trx->addData('orderRef', $orderRef);

        (new SubscriberCoursePatcher($conn))->patch(
            $subscriberCourse->getId(),
            new PatchedSubscriberCourse(null, null, null, null, null, null, $orderRef, null, null, null)
        );


        $subscriber = (new SubscriberById($conn))->byId($subscriberCourse->getSubscriberId());

        // CUSTOMER
        // customer's name
        //-----------------------------------------------------------------------------------------
        //$trx->addData('customer', 'v2 SimplePay Teszt');


        // customer's registration mehod
        // 01: guest
        // 02: registered
        // 05: third party
        //-----------------------------------------------------------------------------------------
        $trx->addData('threeDSReqAuthMethod', '02');


        // EMAIL
        // customer's email
        //-----------------------------------------------------------------------------------------
        $trx->addData('customerEmail', $subscriber->getEmail());


        // LANGUAGE
        // HU, EN, DE, etc.
        //-----------------------------------------------------------------------------------------
        $trx->addData('language', 'HU');


        // TIMEOUT
        // 2018-09-15T11:25:37+02:00
        //-----------------------------------------------------------------------------------------
        $timeoutInSec = 600;
        $timeout = @date("c", time() + $timeoutInSec);
        $trx->addData('timeout', $timeout);


        // METHODS
        // CARD or WIRE
        //-----------------------------------------------------------------------------------------
        $trx->addData('methods', array('CARD'));


        // REDIRECT URLs
        //-----------------------------------------------------------------------------------------

        // common URL for all result
        $trx->addData('url', Router::siteUrl() . '/api/back/' . $subscriberCourse->getId());


        // $trx->addGroupData('urls', 'success', $config['URLS_SUCCESS']);
        // $trx->addGroupData('urls', 'fail', $config['URLS_FAIL']);
        // $trx->addGroupData('urls', 'cancel', $config['URLS_CANCEL']);
        // $trx->addGroupData('urls', 'timeout', $config['URLS_TIMEOUT']);

        if ($subscriberCourse->getPurchaseType() === 'invoice') {
            $trx->addGroupData('invoice', 'name', $subscriberCourse->getName());
            $trx->addGroupData('invoice', 'city', $subscriberCourse->getCity());
            $trx->addGroupData('invoice', 'zip', $subscriberCourse->getZip());
            $trx->addGroupData('invoice', 'address', $subscriberCourse->getAddress());
        }





        //payment starter element
        // auto: (immediate redirect)
        // button: (default setting)
        // link: link to payment page
        //-----------------------------------------------------------------------------------------
        $trx->formDetails['element'] = 'button';


        //create transaction in SimplePay system
        //-----------------------------------------------------------------------------------------
        $trx->runStart();

        return $trx->getReturnData()['paymentUrl'] ?? '';
    }

    public static function getRoutes(Pipeline $r, mysqli $conn, Environment $twig)
    {

        $r->get('/api/reset/{id}', function (Request $request) use ($conn) {
            $id = $request->vars['id'];
            (new SubscriberCourseDeleter($conn))->delete($id);
            header('Location: /react-kurzus');
        });

        $r->post('/api/ipn', function (Request $request) use ($conn) {
            header('Content-Type: application/json; charset=utf-8');

            $subscriberCourses = (new SubscriberCourseLister($conn))->list(new Query(
                1000,
                0,
                new Clause('eq', 'orderRef', $request->body['orderRef']),
                new OrderBy('id', 'asc')
            ));

            if (!$subscriberCourses->getCount()) {
                http_response_code(400);
                echo json_encode(['error' => 'order not found']);
                return;
            }

            require_once 'simplepay/config.php';

            require_once 'simplepay/SimplePayV21.php';

            $trx = new \SimplePayIpn;

            $trx->addConfig($config);

            if (!$trx->isIpnSignatureCheck(json_encode($request->body))) {
                return;
            }

            if (!$trx->runIpnConfirm()) {
                return;
            }


            $subscriberCourse = $subscriberCourses->getEntities()[0];

            (new SubscriberCoursePatcher($conn))->patch(
                $subscriberCourse->getId(),
                new PatchedSubscriberCourse(null, null, null, null, null, null, null, null, true, null)
            );

            $course = (new CourseById($conn))->byId($subscriberCourse->getCourseId());
            $subscriber = (new SubscriberById($conn))->byId($subscriberCourse->getSubscriberId());

            if ($subscriberCourse->getIsInvoiceSent()) {
                return;
            }

            if ($subscriberCourse->getPurchaseType() === 'invoice') {
                Invoice::sendInvoice(
                    $subscriberCourse->getName(),
                    $subscriberCourse->getTaxNumber(),
                    $subscriberCourse->getZip(),
                    $subscriberCourse->getCity(),
                    $subscriberCourse->getAddress(),
                    $subscriber->getEmail(),
                    $course->getInvoiceTitle(),
                    getDiscountedPrice($course)
                );
            } else {
                Invoice::sendReceipt($subscriber->getEmail(), $course->getInvoiceTitle(), getDiscountedPrice($course));
            }
            (new SubscriberCoursePatcher($conn))->patch(
                $subscriberCourse->getId(),
                new PatchedSubscriberCourse(null, null, null, null, null, null, null, null, null, true)
            );
        });

        $r->get('/api/back/{subscriberCourseId}', PublicSite::initSubscriberSession($conn), function (Request $request) use ($conn) {
            //Import config data
            require_once 'simplepay/config.php';

            //Import SimplePayment class
            require_once 'simplepay/SimplePayV21.php';

            $trx = new \SimplePayBack;

            $trx->addConfig($config);


            //result
            //-----------------------------------------------------------------------------------------
            $result = array();
            if (isset($_REQUEST['r']) && isset($_REQUEST['s'])) {
                if ($trx->isBackSignatureCheck($_REQUEST['r'], $_REQUEST['s'])) {
                    $result = $trx->getRawNotification();
                }
            }

            switch ($result['e']) {
                case 'SUCCESS':
                    (new SubscriberCoursePatcher($conn))->patch(
                        $request->vars['subscriberCourseId'],
                        new PatchedSubscriberCourse(null, null, null, null, null, null, null, true, null, null)
                    );

                    header('Location: /react-kurzus?transactionSuccessful=1&orderRef=' . $result['o'] . '&transactionId=' . $result['t']);
                    return;
                    break;
                case 'FAIL':
                    header('Location: /react-kurzus?error=transactionFailed&transactionId=' . $result["t"]);
                    return;
                    break;
                case 'CANCEL':
                    header('Location: /react-kurzus?error=transactionCancelled');
                    return;
                    break;
                case 'TIMEOUT':
                    header('Location: /react-kurzus?error=transactionTimeout');
                    return;
                    break;
            }

            // if (count($result) > 0) {

            //     // QUERY
            //     print '<a href="/api/query?orderRef=' . $result['o'] . '&transactionId=' . $result['t'] . '&merchant=' . $result['m'] . '"> QUERY: ' . $result['t'] . '</a>';
            //     print "<br/><br/>";

            //     // REFUND
            //     print '<a href="refund.php?orderRef=' . $result['o'] . '&transactionId=' . $result['t'] . '&merchant=' . $result['m'] . '"> REFUND 5 HUF</a>';
            //     print "<br/><br/>";
            // }
        });
    }
}
