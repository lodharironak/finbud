import React, { Fragment } from 'react';

import Loader from '../../shared/Loader';
 
const Footer = (props) => {
    return (
        <div className="wpupg-admin-modal-footer">
            {
                props.savingChanges
                ?
                <Loader/>
                :
                <Fragment>
                    { props.children }
                </Fragment>
            }
        </div>
    );
}
export default Footer;