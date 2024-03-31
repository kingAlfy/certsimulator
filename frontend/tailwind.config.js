//const defaultTheme = require('tailwindcss/defaultTheme')
const withMT = require("@material-tailwind/react/utils/withMT");


module.exports = withMT({
    content: ['./src/**/*.js'],
    darkMode: 'media',
    theme: {
        extend: {
/*             fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            }, */
            colors: {
                'ex-primary' : '#ced4da'
            }
        },
    },
    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },
    plugins: [require('@tailwindcss/forms')],
})
