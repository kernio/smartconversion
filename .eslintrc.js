module.exports = {
  env: {
    browser: true,
    es6: true
  },
  settings: {
    react: {
      version: "detect",
    }
  },
  extends: [
    'plugin:react/recommended',
    'standard'
  ],
  globals: {
    Atomics: 'readonly',
    SharedArrayBuffer: 'readonly'
  },
  parser: "@typescript-eslint/parser",
  parserOptions: {
    ecmaFeatures: {
      jsx: true
    },
    ecmaVersion: 2018,
    sourceType: 'module'
  },
  plugins: [
    'react',
     '@typescript-eslint'
  ],
  rules: {
    'indent': ['error', 4, { 'SwitchCase': 1 }],
    'react/jsx-indent-props': [2, 4],
    'react/prop-types': 0,
    'no-unused-vars': 'off',
    '@typescript-eslint/no-unused-vars': [
      'error', {
        'vars': 'all',
        'args': 'after-used',
        'ignoreRestSiblings': false
      }
    ]
  }
}
