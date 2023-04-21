const defaultColors = require('tailwindcss/colors');
const plugin = require('tailwindcss/plugin');


/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php', './resources/views/**/*.blade.php', './resources/js/**/*.vue'],

    theme: {
        extend: {
            transitionDuration:  {
                DEFAULT: '300ms'
            },
            colors:              () => ({
                primary:   defaultColors.slate['900'],
                primaryLight: defaultColors.slate['800'],
                secondary: defaultColors.emerald['600'],
                accent:    defaultColors.yellow['600'],
                success:   defaultColors.green['600'],
                info:      defaultColors.blue['600'],
                warning:   defaultColors.yellow['600'],
                error:     defaultColors.red['600']
            }),
            screens:             {
                'xs':  '320px',
                'sm':  '640px',
                'md':  '768px',
                'lg':  '1024px',
                'xl':  '1280px',
                '2xl': '1536px',
                '3xl': '1920px',
                '4xl': '2048px',
                '5xl': '2560px',
                '6xl': '3840px'
            },
            spacing:             {
                header:  '76px',
                desktop: 'calc(100vh - 76px)'
            },
            minHeight:           ({theme}) => ({
                ...theme('spacing')
            }),
        }
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('@tailwindcss/line-clamp'),
        require('./tailwind/plugins/widthBreakpoints'),
        require('./tailwind/plugins/gridUtils'),
    ]
};
