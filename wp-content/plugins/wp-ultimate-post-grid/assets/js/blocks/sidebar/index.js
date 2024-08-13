const { __ } = wp.i18n;

const { Fragment } = wp.element;
const { PluginSidebar, PluginSidebarMoreMenuItem } = wp.editPost;
const { compose } = wp.compose;
const { withSelect, withDispatch } = wp.data;
const { Panel, PanelBody, Button, withFocusReturn, TextControl, SelectControl } = wp.components;
const { registerPlugin } = wp.plugins;

// Backwards compatibility.
let MediaUpload;
if ( wp.hasOwnProperty( 'blockEditor' ) ) {
	MediaUpload = wp.blockEditor.MediaUpload;
} else {
	MediaUpload = wp.editor.MediaUpload;
}

import '../../../css/blocks/sidebar.scss';

function Sidebar( props ) {
    return (
        <Fragment>
            <PluginSidebarMoreMenuItem
                target="sidebar-wp-ultimate-post-grid"
                icon="grid-view"
            >
            WP Ultimate Post Grid
            </PluginSidebarMoreMenuItem>
            <PluginSidebar
                name="sidebar-wp-ultimate-post-grid"
                title="WP Ultimate Post Grid"
                icon="grid-view"
            >
                <Panel>
                    <PanelBody title={ __( 'Custom Grid Link' ) }>
                        <TextControl
                            label={ __( 'Custom Link URL' ) }
                            value={ props.link }
                            onChange={ ( value ) => props.onChangeMeta( { wpupg_custom_link: [value] } ) }
                        />
                        <SelectControl
                            label={ __( 'Custom Link Behaviour' ) }
                            value={ props.linkBehaviour }
                            options={[
                                { value: 'default', label: __( 'Use grid default' ) },
                                { value: '_self', label: __( 'Open in same tab' ) },
                                { value: '_blank', label: __( 'Open in new tab' ) },
                                { value: 'none', label: __( "Don't use links" ) },
                            ]}
                            onChange={ ( value ) => props.onChangeMeta( { wpupg_custom_link_behaviour: [value] } ) }
                        />
                    </PanelBody>
                    <PanelBody title={ __( 'Custom Grid Image' ) }>
                        <TextControl
                            label={ __( 'Custom Image URL' ) }
                            value={ props.image }
                            onChange={ ( value ) => props.onChangeMeta( { wpupg_custom_image: [value], wpupg_custom_image_id: [0]  } ) }
                        />
                        <TextControl
                            label={ __( 'Custom Image ID' ) }
                            value={ props.imageId ? props.imageId : '' }
                            disabled
                        />
                        <MediaUpload
                            onSelect={
                                ( media ) => {
                                    props.onChangeMeta( { wpupg_custom_image: [media.url], wpupg_custom_image_id: [media.id]  } );
                                }
                            }
                            type="image"
                            value={ props.imageId }
                            render={ ( { open } ) => (
                                <Button
                                    variant="secondary"
                                    onClick={ open }
                                >{ __( 'Choose Image' ) }</Button>
                            ) }
                        />
                        {
                            props.image
                            ?
                            <img
                                className="wpupg-sidebar-custom-image-preview"
                                src={ props.image }
                            />
                            :
                            null
                        }
                    </PanelBody>
                </Panel>
            </PluginSidebar>
        </Fragment>
    )
}

const applyWithSelect = withSelect( ( select, ownProps ) => {
    const meta = select( 'core/editor' ).getEditedPostAttribute( 'meta' );

    if ( ! meta ) {
        return {};
    }

    const linkMeta = meta[ 'wpupg_custom_link' ];
    const link = linkMeta instanceof Array ? linkMeta[0] : linkMeta;

    const linkBehaviourMeta = meta[ 'wpupg_custom_link_behaviour' ];
    const linkBehaviour = linkBehaviourMeta instanceof Array ? linkBehaviourMeta[0] : linkBehaviourMeta;

    const imageMeta = meta[ 'wpupg_custom_image' ];
    const image = imageMeta instanceof Array ? imageMeta[0] : imageMeta;

    const imageIdMeta = meta[ 'wpupg_custom_image_id' ];
    const imageId = imageIdMeta instanceof Array ? imageIdMeta[0] : imageIdMeta;

    return {
        meta,
        link,
        linkBehaviour,
        image,
        imageId,
    }
} );

const applyWithDispatch = withDispatch( ( dispatch, ownProps ) => {
    const { editPost } = dispatch( 'core/editor' );

    return {
        onChangeMeta: ( fields ) => {
            let meta = {
                ...ownProps.meta,
                ...fields,
            };

            return editPost( { meta } );
        },
    }
} );

registerPlugin( 'wp-ultimate-post-grid', {
	render: compose(
        applyWithSelect,
        applyWithDispatch,
        withFocusReturn
    )( Sidebar ),
} );