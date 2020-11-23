(() => {
        let isCollapsed = true;
        document.getElementById("navbar-toggler")
        .addEventListener('click', () => {
            isCollapsed = !isCollapsed;
            render(isCollapsed);
        });

    function render(isCollapsed) {
        if(isCollapsed) {
            document.getElementById("navbar-items").classList.add('d-none')
        } else {
            document.getElementById("navbar-items").classList.remove('d-none')
        }
    }
})();
