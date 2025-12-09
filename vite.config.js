import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import path from 'path'

//const NGROK_URL = 'https://visionhub360.ngrok-free.dev'

export default defineConfig({
   /* server: {
        host: '0.0.0.0',
        port: 5173,
        strictPort: true,
        hmr: {
            host: NGROK_URL.replace('https://', ''),
            protocol: 'wss', // usa WebSocket seguro
        },
    },*/
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            //origin: NGROK_URL,
        }),
        vue(),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
        },
    },
})



