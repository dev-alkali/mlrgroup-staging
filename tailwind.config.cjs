

const plugin = require('tailwindcss/plugin');

module.exports = {
  darkMode: 'class',
  content: [
    "./**/*.php",
    "./**/**/*.php",
    "./assets/**/*.js",
  ],
  theme: {
    extend: {
      colors: {
        // brand: "var(--color-primary)",
        // primary: "var(--text-primary)",
        // secondary: "var(--text-secondary)",
        // success: "var(--color-success)",
        // successDark: "var(--color-success-dark)",
        // error: "var(--color-error)",
        // errorDark: "var(--color-error-dark)",
        // warning: "var(--color-warning)",
        // warningDark: "var(--color-warning-dark)",
        // muted: "var(--bg-muted)",
      },
    },
  },
  plugins: [
    plugin(function ({ addComponents, addUtilities, theme }) {
      addComponents({
        ".nav-link-dashboard": {
          display: "flex",
          alignItems: "center",
          cursor: "pointer",
          transitionProperty: "all",
          transitionDuration: theme("transitionDuration.150"),
          transitionTimingFunction: theme("transitionTimingFunction.in-out"),
          "&:hover": {
            borderBottomWidth: "2px",
            borderColor: theme("colors.white"),
            color: theme("colors.white"),
          },
        },
      });

      addUtilities({
        ".text-stroke": { "-webkit-text-stroke-width": "1px" },
        ".text-stroke-2": { "-webkit-text-stroke-width": "2px" },
        ".text-stroke-white": { "-webkit-text-stroke-color": "#fff" },
        ".text-stroke-black": { "-webkit-text-stroke-color": "#000" },
      });
    }),
  ],
};
