import React from 'react';

import { __wpupg } from 'Shared/Translations';
import FieldDropdown from '../field/FieldDropdown';

const SelectGrid = (props) => {
    let gridOptions = [];

    for ( let grid of wpupg_admin.grids ) {
        gridOptions.push({
            value: grid.slug,
            label: `${ grid.id } - ${ grid.name || 'n/a' }`,
        });
    }
    return (
        <FieldDropdown
            value={ props.value }
            placeholder={ props.placeholder }
            onChange={ props.onChange }
            options={gridOptions}
        />
    );
}
export default SelectGrid;
