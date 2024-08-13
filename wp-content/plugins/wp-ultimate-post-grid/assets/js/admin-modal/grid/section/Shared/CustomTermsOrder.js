import React, { Fragment } from 'react';

import Field from 'Modal/field';
import { __wpupg } from 'Shared/Translations';

const CustomTermsOrder = (props) => {
    const { options } = props;

    return (
        <Fragment>
            {
                options.taxonomies.map( ( taxonomy_key, index ) => {
                    const taxonomy = wpupg_admin_manage_modal.taxonomies[ taxonomy_key ];

                    let termOptions = taxonomy.terms;

                    if ( options.limit ) { 
                        const limitTerms = options.limit_terms.hasOwnProperty( taxonomy_key ) ? options.limit_terms[ taxonomy_key ] : [];

                        if ( 0 < limitTerms.length ) {
                            termOptions = termOptions.filter((option) => {
                                return limitTerms.includes( option.value ) ? ! options.limit_exclude : options.limit_exclude;
                            });
                        }
                    }

                    return (
                        <Field
                            value={ options.custom_term_order.hasOwnProperty( taxonomy_key ) ? options.custom_term_order[ taxonomy_key ] : [] }
                            onChange={ ( value ) => {
                                let newCustomTermOrder = JSON.parse( JSON.stringify( options.custom_term_order ) );
                                
                                // Make sure it's an object.
                                if ( Array.isArray( newCustomTermOrder ) ) {
                                    newCustomTermOrder = {};
                                }
                                newCustomTermOrder[ taxonomy_key ] = value;

                                props.onChange({
                                    custom_term_order: newCustomTermOrder,
                                });
                            }}
                            type="order"
                            id={ `order-terms-${ taxonomy_key }` }
                            options={ termOptions }
                            label={ taxonomy.label }
                            key={ index }
                        />
                    );
                })
            }
        </Fragment>
    );
}
export default CustomTermsOrder;
