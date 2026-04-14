(function () {
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof acf === 'undefined' || typeof acf.addFilter !== 'function') return;

        acf.addFilter('acf.blockEdit', function (props) {
            props.mode = 'edit';
            return props;
        });
    });
})();
