const { hooks } = WPUltimatePostGrid['wp-ultimate-post-grid/dist/shared'];

import General from './General';
import Grid from './Grid';
import Manage from './Manage';
import Preview from './Preview';
import Template from './Template';

const api = hooks.applyFilters( 'api', {
    general: General,
    grid: Grid,
    manage: Manage,
    preview: Preview,
    template: Template,
} );

export default api;