import React, { Fragment } from 'react';

import Field from 'Modal/field';
import { __wpupg } from 'Shared/Translations';

const SectionGeneral = (props) => {
    return (
        <Fragment>
            <Field
                value={ props.grid.name }
                onChange={ ( value ) => {
                    props.onGridChange({
                        name: value,
                    });
                }}
                type="text"
                label={ __wpupg( 'Name' ) }
            />
            <Field
                value={ props.grid.slug }
                onChange={ ( value ) => {
                    props.onGridChange({
                        slug: value,
                    });
                }}
                type="slug"
                label={ __wpupg( 'ID' ) }
                help={ __wpupg( 'Used to identify the grid in the shortcode.' ) }
            />
        </Fragment>
    );
}
export default SectionGeneral;
