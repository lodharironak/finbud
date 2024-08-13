if (!global._babelPolyfill) { require('babel-polyfill'); }
import ReactDOM from 'react-dom';
import React from 'react';
import { HashRouter } from 'react-router-dom';

import ManageApp from './admin-manage/App';

let ManageAppContainer = document.getElementById( 'wpupg-admin-manage' );

if (ManageAppContainer) {
	ReactDOM.render(
		<HashRouter>
    	    <ManageApp/>
  	    </HashRouter>,
		ManageAppContainer
	);
}

import ModalApp from './admin-modal/App';

let ModalAppContainer = document.getElementById( 'wpupg-admin-modal' );

if (ModalAppContainer) {
	ReactDOM.render(
    	<ModalApp
			ref={(app) => {window.WPUPG_Modal = app}}
		/>,
		ModalAppContainer
	);
}