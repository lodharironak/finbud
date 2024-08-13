import '../../css/admin/meta-box.scss';

import { __wpupg } from 'Shared/Translations';

const metaBox = {
    elems: {},
    initPost( container ) {
        this.elems = {
            container,
            imageButton: container.querySelector( '#wpupg_add_custom_image' ),
            imageRemoveButton: false,
            imageUrl: container.querySelector( '#wpupg_custom_image' ),
            imageId: container.querySelector( '#wpupg_custom_image_id' ),
            imagePreview: false,
        };

        this.addEventListeners();
    },
    initTerm( container ) {
        this.elems = {
            container,
            imageButton: container.querySelector( '#wpupg_add_custom_image' ),
            imageRemoveButton: container.querySelector( '#wpupg_remove_custom_image' ),
            imageUrl: container.querySelector( '#wpupg_custom_image_url' ),
            imageId: container.querySelector( '#wpupg_custom_image' ),
            imagePreview: container.querySelector( '#wpupg_custom_image_img' ),
        };

        this.addEventListeners();
    },
    addEventListeners() {
        // Open media library when clicking on button.
        this.elems.imageButton.addEventListener( 'click', (e) => {
            e.preventDefault();

            if ( typeof wp.media == 'function' ) {
                const custom_uploader = wp.media({
                    title: __wpupg( 'Insert Media' ),
                    button: {
                        text: __wpupg( 'Set Custom Image' ),
                    },
                    multiple: false
                });

                custom_uploader.on('select', () => {
                    const attachment = custom_uploader.state().get('selection').first().toJSON();
                    this.elems.imageUrl.value = attachment.url;
                    this.elems.imageId.value = attachment.id;

                    if ( this.elems.imagePreview ) {
                        this.elems.imagePreview.src = attachment.url;
                    }
                    if ( this.elems.imageRemoveButton ) {
                        this.elems.imageButton.style.display = 'none';
                        this.elems.imageRemoveButton.style.display = 'block';
                    }
                }).open();
            }
        });

        if ( this.elems.imageRemoveButton ) {
            this.elems.imageRemoveButton.addEventListener( 'click', (e) => {
                this.elems.imageId.value = '';
                this.elems.imageRemoveButton.style.display = 'none';
                this.elems.imageButton.style.display = 'block';

                if ( this.elems.imagePreview ) {
                    this.elems.imagePreview.src = '';
                }
            });
        }

        // Clear image ID if URL gets changed.
        this.elems.imageUrl.addEventListener( 'keyup', () => {
            this.elems.imageId.value = '';
        } );
        this.elems.imageUrl.addEventListener( 'change', () => {
            this.elems.imageId.value = '';
        } );
    },
}

// Init meta box we can find one when the page is ready.
ready(() => {
    const postMetaBoxContainer = document.querySelector( '#wpupg_meta_box_post' );

    if ( postMetaBoxContainer ) {
        metaBox.initPost( postMetaBoxContainer );
    }

    const termMetaBoxContainer = document.querySelector( '#wpupg_meta_box_term' );

    if ( termMetaBoxContainer ) {
        metaBox.initTerm( termMetaBoxContainer );
    }
});

// Source: http://youmightnotneedjquery.com/#ready
function ready( fn ) {
    if (document.readyState != 'loading'){
        fn();
    } else {
        document.addEventListener('DOMContentLoaded', fn);
    }
}