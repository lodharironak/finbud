import React, { Fragment } from 'react';

import { __wpupg } from 'Shared/Translations';
 
const Totals = (props) => {
    if ( ! props.filtered && ! props.total ) {
        return <div className="wpupg-admin-table-totals">&nbsp;</div>;
    }

    const isFiltered = false !== props.filtered && props.filtered != props.total;

    return (
        <div className="wpupg-admin-table-totals">
            {
                props.total
                ?
                <Fragment>
                    {
                    isFiltered
                    ?
                    `${ __wpupg( 'Showing' ) } ${ Number(props.filtered).toLocaleString() } ${ __wpupg( 'filtered of' ) } ${ Number(props.total).toLocaleString() } ${ __wpupg( 'total' ) }`
                    :
                    `${ __wpupg( 'Showing' ) } ${ Number(props.total).toLocaleString() } ${ __wpupg( 'total' ) }`
                }
                </Fragment>
                :
                `${ Number(props.filtered).toLocaleString() } ${ __wpupg( 'rows' ) }`
            }
        </div>
    );
}
export default Totals;