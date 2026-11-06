import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';
import { fileURLToPath } from 'node:url';

// Root is src/ so index.html lives with the demo. outDir stays at
// repo-root dist/ so the servable output path doesn't change.
// envDir stays at repo root so .env* files live next to package.json
// (Vite defaults envDir to root, i.e. src/).
export default defineConfig({
    root: 'src',
    envDir: fileURLToPath(new URL('.', import.meta.url)),
    base: './',
    build: {
        outDir: '../dist',
        emptyOutDir: true,
    },
    plugins: [tailwindcss()],
});
