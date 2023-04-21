const plugin = require('tailwindcss/plugin');
module.exports = plugin(function ({matchUtilities, theme}) {
        matchUtilities({
            'w-screen':     (value) => ({
                width: value
            }),
            'min-w-screen': (value) => ({
                'min-width': value
            })
        }, {values: theme('screens')});
    }
);

