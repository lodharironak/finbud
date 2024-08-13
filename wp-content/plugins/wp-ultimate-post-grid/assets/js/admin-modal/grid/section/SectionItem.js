import React, { Fragment } from 'react';

import Field from 'Modal/field';
import { __wpupg } from 'Shared/Translations';

const SectionItem = (props) => {
    return (
        <Fragment>
            <Field
                value={ props.grid.template }
                onChange={ ( value ) => {
                    props.onGridChange({
                        template: value,
                    });
                }}
                type="dropdown"
                label={ __wpupg( 'Template' ) }
                options={ wpupg_admin_manage_modal.templates }
            />
            {
                'terms' === props.grid.type
                &&
                <Field
                    value={ props.grid.use_image }
                    onChange={ ( value ) => {
                        props.onGridChange({
                            use_image: value,
                        });
                    }}
                    type="dropdown"
                    label={ __wpupg( 'Image to use' ) }
                    options={[
                        {
                            value: 'default',
                            label: __wpupg( 'Use custom grid image' ),
                        },
                        {
                            value: 'latest_post',
                            label: __wpupg( 'Use featured image of latest post with this term' ),
                        },
                        {
                            value: 'oldest_post',
                            label: __wpupg( 'Use featured image of oldest post with this term' ),
                        },
                        {
                            value: 'random_post',
                            label: __wpupg( 'Use featured image of random post with this term' ),
                        },
                    ]}
                />
            }
            <Field
                value={ props.grid.link }
                onChange={ ( value ) => {
                    props.onGridChange({
                        link: value,
                    });
                }}
                type="checkbox"
                label={ __wpupg( 'Link Entire Item' ) }
                help={ __wpupg( 'Make the full item a link. Other links inside the item will still work as well. When disabled you are responsible for adding a link.' ) }
            />
            {
                props.grid.link
                &&
                <Fragment>
                    <Field
                        value={ props.grid.link_type }
                        onChange={ ( value ) => {
                            props.onGridChange({
                                link_type: value,
                            });
                        }}
                        type="dropdown"
                        label={ __wpupg( 'Link To' ) }
                        options={[
                            {
                                value: 'post',
                                label: __wpupg( 'Post' ),
                            },
                            {
                                value: 'image',
                                label: __wpupg( 'Featured Image' ),
                            }
                        ]}
                    />
                    <Field
                        value={ props.grid.link_target }
                        onChange={ ( value ) => {
                            props.onGridChange({
                                link_target: value,
                            });
                        }}
                        type="dropdown"
                        label={ __wpupg( 'Link Target' ) }
                        options={[
                            {
                                value: '_self',
                                label: __wpupg( 'Open in same tab' ),
                            },
                            {
                                value: '_blank',
                                label: __wpupg( 'Open in new tab' ),
                            }
                        ]}
                    />
                </Fragment>
            }
        </Fragment>
    );
}
export default SectionItem;
