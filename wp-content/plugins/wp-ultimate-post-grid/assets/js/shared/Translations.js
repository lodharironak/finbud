export function __wpupg( text, domain = 'wp-ultimate-post-grid' ) {
    if ( wpupg_admin.translations.hasOwnProperty( text ) ) {
        return wpupg_admin.translations[ text ];
    } else {
        return text;
    }
};
