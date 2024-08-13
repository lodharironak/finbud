import { __wpupg } from 'Shared/Translations';

import ColumnsGrids from './grids/Columns';

let datatables = {
    'grids': {
        parent: __wpupg( 'Grids' ),
        title: __wpupg( 'Overview' ),
        id: 'grids',
        route: 'grids',
        label: {
            singular: __wpupg( 'Grid' ),
            plural: __wpupg( 'Grids' ),
        },
        bulkEdit: {
            route: 'grids',
            type: 'grids',
        },
        createButton: (datatable) => {
            WPUPG_Modal.open( 'create', {
                saveCallback: () => datatable.refreshData(),
            } );
        },
        selectedColumns: ['name', 'shortcode'],
        columns: ColumnsGrids,
    },
}

export default datatables;