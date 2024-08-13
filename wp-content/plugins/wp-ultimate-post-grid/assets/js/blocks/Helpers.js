const { __ } = wp.i18n;
const {
    Button,
    PanelBody,
    TextareaControl,
} = wp.components;

export default {
    dynamicObjectToString( obj, glue = ' ' ) {
        let dynamic = [];
        for ( let key of Object.keys( obj ) ) {
            if ( key ) {
                const value = obj[ key ];

                if ( value ) {
                    dynamic.push( `${key}="${ value }"` );
                }
            }
        }

        return dynamic.join( glue );
    },
    dynamicSidebar( attributes, setAttributes, type = 'grid' ) {
        return (
            <PanelBody title={ 'grid' === type ? __( 'Dynamic Filters' ) : __( 'Default Filter Selections' ) }>
                <p>
                    {
                        ! wpupg_admin.addons.premium
                        &&
                        <span style={ { color: 'darkred' } }>This feature is only available in WP Ultimate Post Grid Premium.<br/></span>
                    }
                    {
                        'grid' === type
                        ?
                        <a href="https://help.bootstrapped.ventures/article/238-limit-items-dynamically" target="_blank">Learn More</a>
                        :
                        <a href="https://help.bootstrapped.ventures/article/247-default-filter-selections" target="_blank">Learn More</a>
                    }
                </p>
                <TextareaControl
                    value={ attributes.dynamic }
                    onChange={( value ) => {
                        // Clean up.
                        value = value.replace( '\n', ' ' );
                        value = value.replace( '\r', ' ' );
                        value = value.replace( '  ', ' ' );

                        setAttributes({
                            dynamic: value,
                        });
                    }}
                />
            </PanelBody>
        )
    }
};
