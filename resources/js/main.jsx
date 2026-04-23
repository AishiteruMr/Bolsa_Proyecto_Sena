import './bootstrap.js';
import { createInertiaApp } from '@inertiajs/react';
import React from 'react';
import ReactDOM from 'react-dom/client';

createInertiaApp({
  resolve: (name) => {
    const pages = import.meta.glob('./pages/**/*.jsx', { eager: true });
    return pages[`./pages/${name}.jsx`].default;
  },
  setup({ el, App, props }) {
    ReactDOM.createRoot(el).render(<App {...props} />);
  },
});