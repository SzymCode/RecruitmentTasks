import { defineNuxtConfig } from 'nuxt/config'

// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2024-11-01',
  devtools: { enabled: true },
  modules: [
    '@nuxt/fonts',
    '@nuxt/test-utils/module',
    '@nuxtjs/html-validator',
    '@nuxtjs/stylelint-module',
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
