if (!global._babelPolyfill) { require('babel-polyfill'); }
import 'whatwg-fetch';

// Shared vendors.
import ReactDOM from 'react-dom';
import React from 'react';

// Global variables.
import { createHooks } from '@wordpress/hooks';
let hooks = createHooks();

export { hooks };