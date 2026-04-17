/** @type {import('tailwindcss').Config} */
export default {
  content: ['./src/**/*.{astro,html,js,jsx,md,mdx,svelte,ts,tsx,vue}'],
  theme: {
    extend: {
      colors: {
        'lidice-orange': '#ff9947',
        'lidice-blue': '#002f55',
        'lidice-gray': '#f7f7f7',
      },
      fontFamily: {
        sans: ['InterTight', 'Noto Sans SC', 'system-ui', 'sans-serif'],
        display: ['Blatant', 'Noto Serif SC', 'serif'],
        zh: ['Noto Sans SC', 'sans-serif'],
        'zh-display': ['Noto Serif SC', 'serif'],
      },
    },
  },
  plugins: [],
};
