wp.domReady(function () {
    function forceAcfEditMode(blocks) {
        if (!blocks || !blocks.length) return;

        blocks.forEach(function (block) {
            if (block.name && block.name.indexOf('acf/') === 0) {
                // Unconditionally set mode to 'edit' for every ACF block found
                wp.data
                    .dispatch('core/block-editor')
                    .updateBlockAttributes(block.clientId, { mode: 'edit' });
            }

            // Recurse — synced patterns nest blocks inside innerBlocks
            if (block.innerBlocks && block.innerBlocks.length) {
                forceAcfEditMode(block.innerBlocks);
            }
        });
    }

    // Wait until the block editor actually has blocks loaded (not just initialised)
    var unsubscribe = wp.data.subscribe(function () {
        var blocks = wp.data.select('core/block-editor').getBlocks();
        if (!blocks || !blocks.length) return;

        // Unsubscribe immediately so this only runs once
        unsubscribe();
        forceAcfEditMode(blocks);
    });
});
