wp.domReady(function () {
    function forceAcfEditMode(blocks) {
        if (!blocks || !blocks.length) return;

        blocks.forEach(function (block) {
            if (block.name && block.name.indexOf('acf/') === 0) {
                var newAttrs = {};
                var needsUpdate = false;

                // ACF 5.x stores mode as a top-level block attribute
                if (block.attributes.mode && block.attributes.mode !== 'edit') {
                    newAttrs.mode = 'edit';
                    needsUpdate = true;
                }

                // ACF stores mode inside the data object as well
                if (
                    block.attributes.data &&
                    block.attributes.data._acf_edit_mode &&
                    block.attributes.data._acf_edit_mode !== 'edit'
                ) {
                    newAttrs.data = Object.assign({}, block.attributes.data, {
                        _acf_edit_mode: 'edit',
                    });
                    needsUpdate = true;
                }

                if (needsUpdate) {
                    wp.data
                        .dispatch('core/block-editor')
                        .updateBlockAttributes(block.clientId, newAttrs);
                }
            }

            // Recurse into inner blocks (handles synced patterns / group blocks)
            if (block.innerBlocks && block.innerBlocks.length) {
                forceAcfEditMode(block.innerBlocks);
            }
        });
    }

    // Wait for the editor to be fully ready before touching blocks
    var unsubscribe = wp.data.subscribe(function () {
        var editor = wp.data.select('core/editor');
        if (!editor || typeof editor.isCleanNewPost === 'undefined') return;

        unsubscribe();

        setTimeout(function () {
            var blocks = wp.data.select('core/block-editor').getBlocks();
            forceAcfEditMode(blocks);
        }, 400);
    });
});
