import React, { Fragment } from 'react';

import Field from 'Modal/field';
import { __wpupg } from 'Shared/Translations';

const SectionDataSource = (props) => {
    let languageOptions = [
        { value: false, label: __wpupg( 'Ignore post language' ) },
    ];
    if ( wpupg_admin_manage_modal.hasOwnProperty( 'multilingual' ) && 'wpml' === wpupg_admin_manage_modal.multilingual.plugin ) {
        languageOptions = languageOptions.concat( Object.values( wpupg_admin_manage_modal.multilingual.languages ) );
    }

    return (
        <Fragment>
            <Field
                value={ props.grid.type }
                onChange={ ( value ) => {
                    props.onGridChange({
                        type: value,
                    });
                }}
                type="dropdown"
                label={ __wpupg( 'Type of Grid' ) }
                options={[
                    {
                        value: 'posts',
                        label: __wpupg( 'Grid of Posts, Pages or Custom Post Types' ),
                    },
                    {
                        value: 'terms',
                        label: `${ __wpupg( 'Grid of Category or Taxonomy Terms' ) }${ wpupg_admin.addons.premium ? '' : ` (${__wpupg( 'Premium Only' ) })` }`,
                    }
                ]}
            />
            {
                'posts' === props.grid.type
                &&
                <Fragment>
                    <Field
                        value={ wpupg_admin.addons.premium ? props.grid.post_types : props.grid.post_types[0] }
                        onChange={ ( value ) => {
                            const post_types = wpupg_admin.addons.premium ? value : [value];
                            props.onGridChange({
                                post_types,
                            });
                        }}
                        type="dropdown"
                        options={ Object.values( wpupg_admin_manage_modal.post_types ) }
                        isMulti={ wpupg_admin.addons.premium }
                        label={ __wpupg( 'Post Types' ) }
                        help={ wpupg_admin.addons.premium ? null : __wpupg( 'Multiple post types are available in WP Ultimate Post Grid Premium' ) }
                    />
                    <Field
                        value={ props.grid.password_protected }
                        onChange={ ( value ) => {
                            props.onGridChange({
                                password_protected: value,
                            });
                        }}
                        type="dropdown"
                        label={ __wpupg( 'Password Protected' ) }
                        options={[
                            {
                                value: 'all',
                                label: __wpupg( 'Include all posts' ),
                            },
                            {
                                value: 'exclude',
                                label: __wpupg( 'Exclude password protected posts' ),
                            },
                            {
                                value: 'only',
                                label: __wpupg( 'Only show password protected posts' ),
                            },
                        ]}
                    />
                    <Field
                        value={ props.grid.post_status }
                        onChange={ ( value ) => {
                            props.onGridChange({
                                post_status: value,
                            });
                        }}
                        type="dropdown"
                        label={ __wpupg( 'Post Status' ) }
                        options={[
                            {
                                value: 'publish',
                                label: __wpupg( 'Published Posts' ),
                            },
                            {
                                value: 'private',
                                label: __wpupg( 'Private Posts' ),
                            },
                            {
                                value: 'future',
                                label: __wpupg( 'Scheduled Posts' ),
                            },
                            {
                                value: 'pending',
                                label: __wpupg( 'Pending Posts' ),
                            },
                            {
                                value: 'draft',
                                label: __wpupg( 'Draft Posts' ),
                            },
                        ]}
                        isMulti
                        help={ __wpupg( 'Select the post statusses you want to display in the grid.' ) }
                    />
                    {
                        props.grid.post_status.includes( 'private' )
                        &&
                        <Field
                            value={ props.grid.post_status_require_permission }
                            onChange={ ( value ) => {
                                props.onGridChange({
                                    post_status_require_permission: value,
                                });
                            }}
                            type="checkbox"
                            label={ __wpupg( 'Only if readable' ) }
                            help={ __wpupg( 'Only show private posts when a visitor has read permission for them.' ) }
                        />
                    }
                    {
                        
                        1 < languageOptions.length
                        &&
                        <Field
                            value={ props.grid.language }
                            onChange={ ( value ) => {
                                props.onGridChange({
                                    language: value,
                                });
                            }}
                            type="dropdown"
                            label={ __wpupg( 'Language' ) }
                            options={ languageOptions }
                        />
                    }
                    <Field
                        value={ props.grid.order_by }
                        onChange={ ( value ) => {
                            props.onGridChange({
                                order_by: value,
                            });
                        }}
                        type="dropdown"
                        options={[
                            { value: 'title', label: __wpupg( 'Title' ) },
                            { value: 'date', label: __wpupg( 'Date' ) },
                            { value: 'modified', label: __wpupg( 'Date Modified' ) },
                            { value: 'author', label: __wpupg( 'Author' ) },
                            { value: 'comment_count', label: __wpupg( 'Comment Count' ) },
                            { value: 'rand', label: __wpupg( 'Random' ) },
                            { value: 'menu_order', label: __wpupg( 'Menu Order (pages)' ) },
                            { value: 'custom', label: `${ __wpupg( 'Custom Field' ) }${ wpupg_admin.addons.premium ? '' : ` (${__wpupg( 'Premium Only' ) })` }`, },
                        ]}
                        label={ __wpupg( 'Order By' ) }
                    />
                    {
                        'custom' === props.grid.order_by
                        &&
                        <Fragment>
                            <Field
                                value={ props.grid.order_custom_key }
                                onChange={ ( value ) => {
                                    props.onGridChange({
                                        order_custom_key: value,
                                    });
                                }}
                                type="text"
                                label={ __wpupg( 'Field Key' ) }
                                help={ __wpupg( 'Key of the custom field to order the grid by.' ) }
                            />
                            <Field
                                value={ props.grid.order_custom_key_numeric }
                                onChange={ ( value ) => {
                                    props.onGridChange({
                                        order_custom_key_numeric: value,
                                    });
                                }}
                                type="checkbox"
                                label={ __wpupg( 'Numeric Field' ) }
                                help={ __wpupg( 'Enable if the custom field contains numbers.' ) }
                            />
                        </Fragment>
                    }
                    <Field
                        value={ props.grid.order }
                        onChange={ ( value ) => {
                            props.onGridChange({
                                order: value,
                            });
                        }}
                        type="dropdown"
                        options={[
                            { value: 'asc', label: __wpupg( 'Ascending' ) },
                            { value: 'desc', label: __wpupg( 'Descending' ) },
                        ]}
                        label={ __wpupg( 'Order' ) }
                    />
                </Fragment>
            }
            {
                'terms' === props.grid.type
                &&
                <Fragment>
                    <Field
                        value={ props.grid.taxonomies }
                        onChange={ ( value ) => {
                            props.onGridChange({
                                taxonomies: value,
                            });
                        }}
                        type="dropdown"
                        options={ Object.values( wpupg_admin_manage_modal.taxonomies ) }
                        isMulti={ true }
                        label={ __wpupg( 'Taxonomies' ) }
                    />
                    <Field
                        value={ props.grid.terms_order_by }
                        onChange={ ( value ) => {
                            props.onGridChange({
                                terms_order_by: value,
                            });
                        }}
                        type="dropdown"
                        options={[
                            { value: 'name', label: __wpupg( 'Name' ) },
                            { value: 'slug', label: __wpupg( 'Slug' ) },
                            { value: 'term_id', label: __wpupg( 'ID' ) },
                            { value: 'description', label: __wpupg( 'Description' ) },
                            { value: 'count', label: __wpupg( 'Post Count' ) },
                        ]}
                        label={ __wpupg( 'Order By' ) }
                    />
                    <Field
                        value={ props.grid.terms_order }
                        onChange={ ( value ) => {
                            props.onGridChange({
                                terms_order: value,
                            });
                        }}
                        type="dropdown"
                        options={[
                            { value: 'asc', label: __wpupg( 'Ascending' ) },
                            { value: 'desc', label: __wpupg( 'Descending' ) },
                        ]}
                        label={ __wpupg( 'Order' ) }
                    />
                </Fragment>
            }
        </Fragment>
    );
}
export default SectionDataSource;
