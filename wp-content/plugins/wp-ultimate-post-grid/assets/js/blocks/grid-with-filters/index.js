import Helpers from '../Helpers';

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const {
    Button,
    Disabled,
    PanelBody,
    ToolbarGroup,
    ToolbarButton,
    TextControl,
} = wp.components;
const { Fragment } = wp.element;

// Backwards compatibility.
let InspectorControls;
let BlockControls;
if ( wp.hasOwnProperty( 'blockEditor' ) ) {
	InspectorControls = wp.blockEditor.InspectorControls;
	BlockControls = wp.blockEditor.BlockControls;
} else {
	InspectorControls = wp.editor.InspectorControls;
	BlockControls = wp.editor.BlockControls;
}

let ServerSideRender;
if ( wp.hasOwnProperty( 'serverSideRender' ) ) {
    ServerSideRender = wp.serverSideRender;
} else {
    ServerSideRender = wp.components.ServerSideRender;
}

import '../../../css/blocks/grid.scss';

registerBlockType( 'wp-ultimate-post-grid/grid-with-filters', {
    title: __( 'Grid with Filters' ),
    description: __( 'Display an entire WP Ultimate Post Grid with filters. Take note  that' ),
    icon: 'grid-view',
    keywords: [ 'wpupg' ],
    category: 'wp-ultimate-post-grid',
    supports: {
        html: false,
        align: true,
    },
    transforms: {
        from: [
            {
                type: 'shortcode',
                tag: 'wpupg-grid-with-filters',
                attributes: {
                    id: {
                        type: 'string',
                        shortcode: ( { named: { id = '' } } ) => {
                            return id.replace( 'id', '' );
                        },
                    },
                    dynamic: {
                        type: 'string',
                        shortcode: ( { named } ) => {
                            delete named.id;
                            delete named.align;
                            return Helpers.dynamicObjectToString( named );
                        },
                    },
                },
            },
        ]
    },
    edit: (props) => {
        const { attributes, setAttributes, className } = props;

        const insertGridModal = () => {
            WPUPG_Modal.open( 'select', {
                title: __( 'Insert Grid with Filters' ),
                button: __( 'Insert' ),
                fields: {
                    grid: true,
                    filters: false,
                },
                insertCallback: ( fields ) => {
                    setAttributes({
                        id: '' + fields.grid,
                        updated: Date.now(),
                    });
                },
            }, true );
        }

        return (
            <div className={ className }>{
                attributes.id
                ?
                <Fragment>
                    <BlockControls>
                        <ToolbarGroup>
                            <ToolbarButton
                                icon="edit"
                                label={ __( 'Change Grid' ) }
                                onClick={ insertGridModal }
                            />
                        </ToolbarGroup>
                    </BlockControls>
                    <InspectorControls>
                        <PanelBody title={ __( 'Grid Details' ) }>
                            <TextControl
                                label={ __( 'Grid ID' ) }
                                value={ attributes.id }
                                disabled
                            />
                        </PanelBody>
                        { Helpers.dynamicSidebar( attributes, setAttributes ) }
                    </InspectorControls>
                    <Disabled>
                        <div
                            style={{
                                fontSize: 10,
                                textAlign: 'center',
                            }}
                        >{ __( '(This is just a preview and will look different on the actual site)')}</div>
                        <ServerSideRender
                            block="wp-ultimate-post-grid/grid-with-filters"
                            attributes={ attributes }
                        />
                    </Disabled>
                </Fragment>
                :
                <Fragment>
                    <h5>WP Ultimate Post Grid - { __( 'Grid with Filters' ) }</h5>
                    <Button
                        isPrimary
                        isLarge
                        onClick={ insertGridModal }>
                        { __( 'Insert Existing Grid' ) }
                    </Button>
                </Fragment>
            }</div>
        )
    },
    save: (props) => {
        const { attributes } = props;

        if ( attributes.id ) {
            const dynamic = attributes.dynamic.trim();

            return `[wpupg-grid-with-filters id="${ attributes.id }"${ dynamic ? ` ${dynamic}` : ''}]`;
        } else {
            return null;
        }
    },
} );