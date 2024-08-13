import React, { Fragment } from 'react';

import EditMode from 'Modal/general/EditMode';
import Field from 'Modal/field';
import { __wpupg } from 'Shared/Translations';

import ButtonStyle from '../Shared/ButtonStyle';
import CustomTermsOrder from '../Shared/CustomTermsOrder';
import CustomFieldOptions from '../Shared/CustomFieldOptions';

const FilterIsotope = (props) => {
    const { options } = props;

    let taxonomyOptions = [];
    let taxonomyOrderOptions = [];
    for ( let post_type_key of props.grid.post_types ) {
        if ( wpupg_admin_manage_modal.post_types.hasOwnProperty( post_type_key ) ) {
            const postType = wpupg_admin_manage_modal.post_types[ post_type_key ];

            taxonomyOptions.push({
                label: postType.label,
                options: postType.taxonomies.map( ( taxonomy_key ) => {
                    if ( wpupg_admin_manage_modal.taxonomies.hasOwnProperty( taxonomy_key ) ) {
                        return wpupg_admin_manage_modal.taxonomies[taxonomy_key];
                    }
                }),
            });

            postType.taxonomies.map( ( taxonomy_key ) => {
                if ( wpupg_admin_manage_modal.taxonomies.hasOwnProperty( taxonomy_key ) ) {
                    // Add each taxonomy only once.
                    if ( -1 === taxonomyOrderOptions.findIndex((option) => option.value === wpupg_admin_manage_modal.taxonomies[taxonomy_key].value ) ) {
                        taxonomyOrderOptions.push({
                            value: wpupg_admin_manage_modal.taxonomies[taxonomy_key].value,
                            label: wpupg_admin_manage_modal.taxonomies[taxonomy_key].label,
                        })
                    }
                }
            })
        }
    }

    let modes = {
        general: {
            label: __wpupg( 'Isotope Filter Options' ),
            block: (
                <Fragment>
                    <Field
                        value={ options.source }
                        onChange={ ( value ) => {
                            props.onChange({
                                source: value,
                            });
                        }}
                        type="dropdown"
                        options={[
                            {
                                value: 'taxonomies',
                                label: __wpupg( 'Taxonomies' ),
                            },
                            {
                                value: 'custom_field',
                                label: __wpupg( 'Custom Field' ),
                            }
                        ]}
                        label={ __wpupg( 'Source' ) }
                    />
                    {
                        'taxonomies' === options.source
                        &&
                        <Fragment>
                            <Field
                                value={ options.taxonomies }
                                onChange={ ( value ) => {
                                    props.onChange({
                                        taxonomies: value,
                                    });
                                }}
                                type="dropdown"
                                options={ taxonomyOptions }
                                isMulti={ true }
                                label={ __wpupg( 'Taxonomies' ) }
                            />
                            {
                                2 <= options.taxonomies.length
                                &&
                                <Field
                                    value={ options.taxonomies }
                                    onChange={ ( value ) => {
                                        props.onChange({
                                            taxonomies: value,
                                        });
                                    }}
                                    type="order"
                                    id="taxonomies-order"
                                    options={ taxonomyOrderOptions.filter( (option) => options.taxonomies.includes( option.value ) ) }
                                    label={ __wpupg( 'Taxonomies Order' ) }
                                />
                            }
                            {
                                0 < options.taxonomies.length
                                &&
                                <Fragment>
                                    <Field
                                        value={ options.match_parents }
                                        onChange={ ( value ) => { props.onChange({ match_parents: value }); }}
                                        type="checkbox"
                                        label={ __wpupg( 'Selecting parent terms matches children' ) }
                                        help={ __wpupg( 'Selecting a parent term will also match posts with one of its child terms.' ) }
                                    />
                                    <Field
                                        value={ options.inverse }
                                        onChange={ ( value ) => { props.onChange({ inverse: value }); }}
                                        type="checkbox"
                                        label={ __wpupg( 'Inverse Selection' ) }
                                        help={ __wpupg( 'Items that match the selection will be hidden.' ) }
                                    />
                                    <Field
                                        value={ options.show_empty }
                                        onChange={ ( value ) => { props.onChange({ show_empty: value }); }}
                                        type="checkbox"
                                        label={ __wpupg( 'Show Empty' ) }
                                        help={ __wpupg( "Show terms that don't have any posts." ) }
                                    />
                                    <Field
                                        value={ options.count }
                                        onChange={ ( value ) => { props.onChange({ count: value }); }}
                                        type="checkbox"
                                        label={ `${ __wpupg( 'Show Count' ) }${ wpupg_admin.addons.premium ? '' : '*' }` }
                                        help={ `${ __wpupg( 'Show number of posts for each term.' ) }${ wpupg_admin.addons.premium ? '' : ` (${__wpupg( 'Premium Only' ) })` }` }
                                    />
                                    <Field
                                        value={ options.multiselect }
                                        onChange={ ( value ) => { props.onChange({ multiselect: value }); }}
                                        type="checkbox"
                                        label={ `${ __wpupg( 'Multi-select' ) }${ wpupg_admin.addons.premium ? '' : '*' }` }
                                        help={ `${ __wpupg( 'Allow users to select multiple terms.' ) }${ wpupg_admin.addons.premium ? '' : ` (${__wpupg( 'Premium Only' ) })` }` }
                                    />
                                    {
                                        options.multiselect
                                        &&
                                        <Field
                                            value={ options.multiselect_type }
                                            onChange={ ( value ) => { props.onChange({ multiselect_type: value }); }}
                                            type="dropdown"
                                            options={[
                                                {
                                                    value: 'match_all',
                                                    label: __wpupg( 'Only posts that match all selected terms' ),
                                                },
                                                {
                                                    value: 'match_one',
                                                    label: __wpupg( 'All posts that match any of the selected terms' ),
                                                }
                                            ]}
                                            label={ __wpupg( 'Multi-select Behaviour' ) }
                                        />
                                    }
                                </Fragment>
                            }
                        </Fragment>
                    }
                    {
                        'custom_field' === options.source
                        &&
                        <Fragment>
                            <Field
                                value={ options.custom_field }
                                onChange={ ( value ) => {
                                    props.onChange({
                                        custom_field: value,
                                    });
                                }}
                                type="text"
                                label={ __wpupg( 'Custom Field Key' ) }
                                help={ __wpupg( 'Key of the custom field to use.' ) }
                            />
                            {
                                options.custom_field
                                &&
                                <Fragment>
                                    <Field
                                        value={ options.all_button_text }
                                        onChange={ ( value ) => { props.onChange({ all_button_text: value }); }}
                                        type="text"
                                        label={ __wpupg( 'All Button Text' ) }
                                        help={ `${ __wpupg( 'Text shown on the "All" button.' ) } ${ __wpupg( 'Make the field empty to hide the button.' ) }` }
                                    />
                                    <Field
                                        value={ options.custom_field_numeric }
                                        onChange={ ( value ) => { props.onChange({ custom_field_numeric: value }); }}
                                        type="checkbox"
                                        label={ __wpupg( 'Numeric Field' ) }
                                        help={ __wpupg( 'Enable if the custom field contains numbers.' ) }
                                    />
                                    {
                                        ! options.custom_field_numeric
                                        &&
                                        <Field
                                            value={ options.custom_field_fuzzy }
                                            onChange={ ( value ) => { props.onChange({ custom_field_fuzzy: value }); }}
                                            type="checkbox"
                                            label={ __wpupg( 'Fuzzy Matching' ) }
                                            help={ __wpupg( 'Enable to use fuzzy matching. For example: option value "app" will match custom field value "apple".' ) }
                                        />
                                    }
                                    <Field
                                        value={ options.inverse }
                                        onChange={ ( value ) => { props.onChange({ inverse: value }); }}
                                        type="checkbox"
                                        label={ __wpupg( 'Inverse Selection' ) }
                                        help={ __wpupg( 'Items that match the selection will be hidden.' ) }
                                    />
                                    <Field
                                        value={ options.multiselect }
                                        onChange={ ( value ) => { props.onChange({ multiselect: value }); }}
                                        type="checkbox"
                                        label={ `${ __wpupg( 'Multi-select' ) }${ wpupg_admin.addons.premium ? '' : '*' }` }
                                        help={ `${ __wpupg( 'Allow users to select multiple terms.' ) }${ wpupg_admin.addons.premium ? '' : ` (${__wpupg( 'Premium Only' ) })` }` }
                                    />
                                    {
                                        options.multiselect
                                        &&
                                        <Field
                                            value={ options.multiselect_type }
                                            onChange={ ( value ) => { props.onChange({ multiselect_type: value }); }}
                                            type="dropdown"
                                            options={[
                                                {
                                                    value: 'match_all',
                                                    label: __wpupg( 'Only posts that match all selected terms' ),
                                                },
                                                {
                                                    value: 'match_one',
                                                    label: __wpupg( 'All posts that match any of the selected terms' ),
                                                }
                                            ]}
                                            label={ __wpupg( 'Multi-select Behaviour' ) }
                                        />
                                    }
                                </Fragment>
                            }
                        </Fragment>
                    }
                </Fragment>
            ),
        },
    }

    if ( 'taxonomies' === options.source && 0 < options.taxonomies.length ) {
        modes['filter_terms'] = {
            label: __wpupg( 'Filter Terms' ),
            block: (
                <Fragment>
                    <Field
                        value={ options.all_button_text }
                        onChange={ ( value ) => { props.onChange({ all_button_text: value }); }}
                        type="text"
                        label={ __wpupg( 'All Terms Button' ) }
                        help={ `${ __wpupg( 'Text shown on the "All" button.' ) } ${ __wpupg( 'Make the field empty to hide the button.' ) }` }
                    />
                    <Field
                        value={ options.term_order }
                        onChange={ ( value ) => { props.onChange({ term_order: value }); }}
                        type="dropdown"
                        options={[
                            {
                                value: 'alphabetical',
                                label: __wpupg( 'Alphabetical' ),
                            },
                            {
                                value: 'reverse_alphabetical',
                                label: __wpupg( 'Reverse Alphabetical' ),
                            },
                            {
                                value: 'alphabetical_taxonomies',
                                label: __wpupg( 'Alphabetical per Taxonomy' ),
                            },
                            {
                                value: 'reverse_alphabetical_taxonomies',
                                label: __wpupg( 'Reverse Alphabetical per Taxonomy' ),
                            },
                            {
                                value: 'alphabetical_taxonomies_grouped',
                                label: __wpupg( 'Alphabetical per Taxonomy (separate lines)' ),
                            },
                            {
                                value: 'reverse_alphabetical_taxonomies_grouped',
                                label: __wpupg( 'Reverse Alphabetical per Taxonomy (separate lines)' ),
                            },
                            {
                                value: 'count_asc',
                                label: __wpupg( 'Ascending Count' ),
                            },
                            {
                                value: 'count_desc',
                                label: __wpupg( 'Descending Count' ),
                            },
                            {
                                value: 'custom',
                                label: __wpupg( 'Custom Order' ),
                            },
                        ]}
                        label={ __wpupg( 'Term Order' ) }
                        help={ __wpupg( 'Order of the Isotope term buttons.' ) }
                    />
                    <Field
                        value={ options.limit }
                        onChange={ ( value ) => { props.onChange({ limit: value }); }}
                        type="checkbox"
                        label={ __wpupg( 'Limit Terms' ) }
                        help={ __wpupg( 'Only show/hide selected terms in the filter.' ) }
                    />
                    {
                        options.limit
                        &&
                        <Fragment>
                            {
                                options.taxonomies.map( ( taxonomy_key, index ) => {
                                    const taxonomy = wpupg_admin_manage_modal.taxonomies[ taxonomy_key ];
                                    const selectedTerms = options.limit_terms.hasOwnProperty( taxonomy_key ) ? options.limit_terms[ taxonomy_key ] : [];

                                    if ( ! taxonomy ) {
                                        return null;
                                    }

                                    return (
                                        <Field
                                            value={ selectedTerms }
                                            onChange={ ( value ) => {
                                                let newLimitTerms = JSON.parse( JSON.stringify( options.limit_terms ) );
                                                
                                                // Make sure it's an object.
                                                if ( Array.isArray( newLimitTerms ) ) {
                                                    newLimitTerms = {};
                                                }
                                                newLimitTerms[ taxonomy_key ] = value;

                                                props.onChange({
                                                    limit_terms: newLimitTerms,
                                                });
                                            }}
                                            type="dropdown"
                                            options={ taxonomy.terms }
                                            isMulti={ true }
                                            label={ taxonomy.label }
                                            key={ index }
                                        />
                                    );
                                })
                            }
                            <Field
                                value={ options.limit_exclude }
                                onChange={ ( value ) => { props.onChange({ limit_exclude: value }); }}
                                type="checkbox"
                                label={ __wpupg( 'Exclude Selected Terms' ) }
                            />
                        </Fragment>
                    }
                </Fragment>
            ),
        }

        if ( 'custom' === options.term_order ) {
            modes['filter_terms_order'] = {
                label: __wpupg( 'Custom Terms Order' ),
                block: (
                    <CustomTermsOrder
                        grid={ props.grid }
                        options={ props.options }
                        onChange={ props.onChange }
                    />
                ),
            }
        }
    }

    if ( 'custom_field' === options.source && options.custom_field ) {
        modes['custom_field_options'] = {
            label: __wpupg( 'Custom Field Options' ),
            block: (
                <Fragment>
                    <CustomFieldOptions
                        grid={ props.grid }
                        options={ props.options }
                        onChange={ ( options ) => {
                            props.onChange( options );
                        }}
                    />
                </Fragment>
            ),
        }
    }

    if ( ( 'taxonomies' === options.source && 0 < options.taxonomies.length ) || ( 'custom_field' === options.source && options.custom_field ) ) {
        modes['styling'] = {
            label: __wpupg( 'Button Styling' ),
            block: (
                <Fragment>
                    <ButtonStyle
                        grid={ props.grid }
                        options={ props.options }
                        style={ props.options.style }
                        onChange={ ( style ) => {
                            props.onChange({
                                style: {
                                    ...props.options.style,
                                    ...style,
                                },
                            });
                        }}
                    />
                </Fragment>
            ),
        }
    }

    return (
        <EditMode
            modes={ modes }
        />
    );
}
export default FilterIsotope;
