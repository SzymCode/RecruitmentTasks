import Lara from '@primeuix/themes/lara'
import { defineNuxtConfig } from 'nuxt/config'

// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2024-11-01',
  devtools: { enabled: true },
  modules: [
    '@nuxt/icon',
    '@nuxt/test-utils/module',
    '@nuxtjs/google-fonts',
    '@nuxtjs/html-validator',
    '@nuxtjs/stylelint-module',
    '@primevue/nuxt-module',
  ],
  ssr: true,
  nitro: {
    prerender: {
      routes: ['/home'],
      crawlLinks: true,
    },
    output: {
      publicDir: './public/build',
    },
    minify: true,
    compressPublicAssets: true,
  },
  srcDir: 'nuxt',
  app: {
    head: {
      htmlAttrs: {
        lang: 'en',
      },
      title: 'PatientManager',
      meta: [
        { charset: 'utf-8' },
        { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      ],
    },
  },
  vite: {
    css: {
      preprocessorOptions: {
        scss: {
          api: 'modern',
        },
      },
    },
  },
  components: [{ path: '~/components', extensions: ['vue'] }],
  htmlValidator: {
    options: {
      rules: {
        'element-case': 'off',
      },
    },
  },
  primevue: {
    autoImport: true,
    options: {
      theme: {
        preset: Lara,
      },
      ripple: true,
    },
  },
  googleFonts: {
    families: {
      Inter: '300..700',
      Nunito: '300..700',
    },
    display: 'swap',
    subsets: ['latin'],
  },
  icon: {
    prefix: 'i-prime',
    mode: 'css',
  },
  // Production: Laravel serves prebuilt Nuxt app
  // Development: Nuxt serves app with its own routes
  routeRules:
    process.env.APP_ENV === 'production'
      ? {}
      : {
          '/': { redirect: { to: '/home', statusCode: 301 } },
        },
  // biome-ignore lint/suspicious/noExplicitAny: Nuxt config complexity
} as any)
