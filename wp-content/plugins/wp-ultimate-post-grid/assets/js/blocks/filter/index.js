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

registerBlockType( 'wp-ultimate-post-grid/filter', {
    title: __( 'Grid Filter' ),
    description: __( 'Display filter for a WP Ultimate Post Grid with filters.' ),
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
                tag: 'wpupg-filter',
                attributes: {
                    id: {
                        type: 'string',
                        shortcode: ( { named: { id = '' } } ) => {
                            return id.replace( 'id', '' );
                        },
                    },
                    filter: {
                        type: 'string',
                        shortcode: ( { named: { filter = '' } } ) => {
                            return filter.replace( 'filter', '' );
                        },
                    },
                    dynamic: {
                        type: 'string',
                        shortcode: ( { named } ) => {
                            delete named.id;
                            delete named.align;
                            delete named.filter;
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
                title: __( 'Insert Grid Filter' ),
                button: __( 'Insert' ),
                fields: {
                    grid: true,
                    filter: true,
                },
                insertCallback: ( fields ) => {
                    setAttributes({
                        id: '' + fields.grid,
                        filter: true === fields.filter ? '' : '' + fields.filter,
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
                                label={ __( 'Change Filter' ) }
                                onClick={ insertGridModal }
                            />
                        </ToolbarGroup>
                    </BlockControls>
                    <InspectorControls>
                        <PanelBody title={ __( 'Filter Details' ) }>
                            <TextControl
                                label={ __( 'Grid ID' ) }
                                value={ attributes.id }
                                disabled
                            />
                            <TextControl
                                label={ __( 'Filter ID' ) }
                                value={ ! attributes.filter ? __( 'All Filters' ) : attributes.filter }
                                disabled
                            />
                        </PanelBody>
                        { Helpers.dynamicSidebar( attributes, setAttributes, 'filter' ) }
                    </InspectorControls>
                    <Disabled>    
                        <ServerSideRender
                            block="wp-ultimate-post-grid/filter"
                            attributes={ attributes }
                        />
                    </Disabled>
                </Fragment>
                :
                <Fragment>
                    <h5>WP Ultimate Post Grid - { __( 'Filter' ) }</h5>
                    <Button
                        isPrimary
                        isLarge
                        onClick={ insertGridModal }>
                        { __( 'Insert Existing Filter' ) }
                    </Button>
                </Fragment>
            }</div>
        )
    },
    save: (props) => {
        const { attributes } = props;

        if ( attributes.id ) {
            const dynamic = attributes.dynamic.trim();

            if ( attributes.filter ) {
                return `[wpupg-filter id="${ attributes.id }" filter="${ attributes.filter }"${ dynamic ? ` ${dynamic}` : ''}]`;
            } else {
                return `[wpupg-filter id="${ attributes.id }"${ dynamic ? ` ${dynamic}` : ''}]`;
            }
        } else {
            return null;
        }
    },
} );