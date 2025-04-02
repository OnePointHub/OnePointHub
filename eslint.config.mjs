import antfu from '@antfu/eslint-config'

export default antfu({
  ignores: [
    '**/resources/js/components/ui/**',
    '**/storage/**',
    '**/package.json',
    '**/composer.json',
  ],
})
