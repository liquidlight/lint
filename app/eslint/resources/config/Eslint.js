// All the rules! http://eslint.org/docs/rules/
module.exports = {
	'parserOptions': {
		'sourceType': 'module',
		'ecmaVersion': 2020
	},
	'globals': {
		// Undefined vars (no-undef)
		'$': true,
		'jQuery': true,
		'Vue': true,
		'Vuex': true,
		'google': true
	},
	'env': {
		'browser': true,
		'es6': true,
		'node': true
	},
	'extends': [
		'eslint:recommended',
		'plugin:playwright/recommended'
	],
	'rules': {
		// Possible errors
		'for-direction': 'warn', // disallow trailing commas in object literals
		'no-compare-neg-zero': 'error', // 	disallow comparing against -0
		'no-cond-assign': 'error', // disallow assignment in conditional expressions
		'no-console': 'warn', // disallow use of console
		'no-constant-condition': 'error', // disallow use of constant expressions in conditions
		'no-control-regex': 'error', // disallow control characters in regular expressions
		'no-debugger': 'error', // disallow use of debugger
		'no-dupe-args': 'error', // disallow duplicate arguments in functions
		'no-dupe-keys': 'error', // disallow duplicate keys when creating object literals
		'no-duplicate-case': 'error', // disallow a duplicate case label.
		'no-empty-character-class': 'error', // disallow the use of empty character classes in regular expressions
		'no-empty': 'error', // disallow empty statements
		'no-ex-assign': 'error', // disallow assigning to the exception in a catch block
		'no-extra-boolean-cast': 'error', // disallow double-negation boolean casts in a boolean context
		'no-extra-parens': 'off', // disallow unnecessary parentheses
		'no-extra-semi': 'error', // disallow unnecessary semicolons
		'no-func-assign': 'error', // disallow overwriting functions written as function declarations
		'no-inner-declarations': ['error', 'functions'], // disallow function or variable declarations in nested blocks
		'no-invalid-regexp': 'error', // disallow invalid regular expression strings in the RegExp constructor
		'no-irregular-whitespace': 'error', // disallow irregular whitespace outside of strings and comments
		'no-negated-in-lhs': 'error', // disallow negation of the left operand of an in expression
		'no-obj-calls': 'error', // disallow the use of object properties of the global object (Math and JSON) as functions
		'no-regex-spaces': 'error', // disallow multiple spaces in a regular expression literal
		'no-sparse-arrays': 'error', // disallow sparse arrays
		'no-unexpected-multiline': 'off', // Avoid code that looks like two expressions but is actually one
		'no-unreachable': 'error', // disallow unreachable statements after a return, throw, continue, or break statement
		'use-isnan': 'error', // disallow comparisons with the value NaN
		'valid-jsdoc': 'off', // ensure JSDoc comments are valid
		'valid-typeof': 'error', // ensure that the results of typeof are compared against a valid string

		// Best practices
		'accessor-pairs': 'off', // Enforces getter/setter pairs in objects
		'block-scoped-var': 'off', // treat var statements as if they were block scoped
		'complexity': ['off', 11], // specify the maximum cyclomatic complexity allowed in a program
		'consistent-return': 'off', // require return statements to either always or never specify values
		'curly': ['off', 'all'], // specify curly brace conventions for all control statements
		'default-case': 'off', // require default case in switch statements
		'dot-location': 'off', // enforces consistent newlines before or after dots
		'dot-notation': ['off', {'allowKeywords': true}], // encourages use of dot notation whenever possible
		'eqeqeq': 'off', // require the use of === and !==
		'guard-for-in': 'off', // make sure for-in loops have an if statement
		'no-alert': 'off', // disallow the use of alert, confirm, and prompt
		'no-caller': 'off', // disallow use of arguments.caller or arguments.callee
		'no-case-declarations': 'off', // disallow lexical declarations in case clauses
		'no-constant-binary-expression': 'error', // disallow expressions where the operation doesn't affect the value
		'no-div-regex': 'off', // disallow division operators explicitly at beginning of regular expression
		'no-else-return': 'off', // disallow else after a return in an if
		'no-empty-pattern': 'off', // disallow use of empty destructuring patterns
		'no-eq-null': 'off', // disallow comparisons to null without a type-checking operator
		'no-eval': 'off', // disallow use of eval()
		'no-extend-native': 'off', // disallow adding to native types
		'no-extra-bind': 'off', // disallow unnecessary function binding
		'no-fallthrough': 'error', // disallow fallthrough of case statements
		'no-floating-decimal': 'off', // disallow the use of leading or trailing decimal points in numeric literals
		'no-implicit-coercion': 'off', // disallow the type conversions with shorter notations
		'no-implied-eval': 'off', // disallow use of eval()-like methods
		'no-invalid-this': 'off', // disallow this keywords outside of classes or class-like objects
		'no-iterator': 'off', // disallow usage of __iterator__ property
		'no-labels': 'off', // disallow use of labeled statements
		'no-lone-blocks': 'off', // disallow unnecessary nested blocks
		'no-loop-func': 'off', // disallow creation of functions within loops
		'no-magic-numbers': 'off', // disallow the use of magic numbers
		'no-multi-spaces': 'off', // disallow use of multiple spaces
		'no-multi-str': 'off', // disallow use of multiline strings
		'no-native-reassign': 'off', // disallow reassignments of native objects
		'no-new-func': 'off', // disallow use of new operator for Function object
		'no-new-wrappers': 'off', // disallows creating new instances of String,Number, and Boolean
		'no-new': 'off', // disallow use of new operator when not part of the assignment or comparison
		'no-octal-escape': 'off', // disallow use of octal escape sequences in string literals, such as
		'no-octal': 'error', // disallow use of (old style) octal literals
		'no-param-reassign': 'off', // disallow reassignment of function parameters
		'no-process-env': 'off', // disallow use of process.env
		'no-proto': 'off', // disallow usage of __proto__ property
		'no-redeclare': 'error', // disallow declaring the same variable more then once
		'no-return-assign': 'off', // disallow use of assignment in return statement
		'no-script-url': 'off', // disallow use of `javascript:` urls.
		'no-self-compare': 'off', // disallow comparisons where both sides are exactly the same
		'no-sequences': 'off', // disallow use of comma operator
		'no-throw-literal': 'off', // restrict what can be thrown as an exception
		'no-unused-expressions': 'off', // disallow usage of expressions in statement position
		'no-useless-call': 'off', // disallow unnecessary .call() and .apply()
		'no-useless-concat': 'off', // disallow unnecessary concatenation of literals or template literals
		'no-void': 'off', // disallow use of void operator
		'no-warning-comments': ['off', {'terms': ['todo', 'fixme', 'xxx'], 'location': 'start'}], // disallow usage of configurable warning terms in comments: e.g. todo
		'no-with': 'off', // disallow use of the with statement
		'radix': 'off', // require use of the second argument for parseInt()
		'vars-on-top': 'off', // requires to declare all vars on top of their containing scope
		'wrap-iife': 'off', // require immediate function invocation to be wrapped in parentheses
		'yoda': ['off', 'never'], // require or disallow Yoda conditions

		// Strict
		'strict': 'off',

		// Variables
		'init-declarations': 'off', // enforce or disallow variable initializations at definition
		'no-catch-shadow': 'off', // disallow the catch clause parameter name being the same as a variable in the outer scope
		'no-delete-var': 'error', // disallow deletion of variables
		'no-label-var': 'off', // disallow labels that share a name with a variable
		'no-shadow-restricted-names': 'off', // disallow shadowing of names such as arguments
		'no-shadow': 'off', // disallow declaration of variables already declared in the outer scope
		'no-undef-init': 'off', // disallow use of undefined when initializing variables
		'no-undef': 'warn', // disallow use of undeclared variables unless mentioned in a /*global */ block
		'no-undefined': 'warn', // disallow use of undefined variable
		'no-unused-vars': ['error', {'vars': 'all', 'args': 'after-used'}], // disallow declaration of variables that are not used in the code
		'no-use-before-define': 'off', // disallow use of variables before they are defined

		// Node.js & CommonJS
		'no-mixed-requires': ['warn'],

		// Stylistic issues
		'array-bracket-spacing': ['warn', 'never'], // enforce spacing inside array brackets
		'block-spacing': 'off', // disallow or enforce spaces inside of single line blocks
		'brace-style': ['warn', '1tbs'], // enforce one true brace style
		'camelcase': 'off', // require camel case names
		'comma-dangle': ['error', 'never'], // disallow trailing commas in object literals
		'comma-spacing': ['warn', {'before': false, 'after': true}], // enforce spacing before and after comma
		'comma-style': ['warn', 'last'], // enforce one true comma style
		'computed-property-spacing': ['off', 'never'], // require or disallow padding inside computed properties
		'consistent-this': ['off', 'that'], // enforces consistent naming when capturing the current execution context
		'eol-last': 'off', // enforce newline at the end of file, with no multiple empty lines
		'func-names': 'off', // require function expressions to have a name
		'func-style': ['off', 'declaration'], // enforces use of function declarations or expressions
		'id-length': 'off', // this option enforces minimum and maximum identifier lengths (variable names, property names etc.)
		'id-match': 'off', // require identifiers to match the provided regular expression
		'indent': ['warn', 'tab', {
			'SwitchCase': 1
		}], // this option sets a specific tab width for your code
		'jsx-quotes': 'off', // specify whether double or single quotes should be used in JSX attributes
		'key-spacing': ['warn', {'beforeColon': false, 'afterColon': true}], // enforces spacing between keys and values in object literal properties
		'linebreak-style': ['warn', 'unix'], // disallow mixed 'LF' and 'CRLF' as linebreaks
		'lines-around-comment': 'off', // enforces empty lines around comments
		'max-depth': ['off', 4], // specify the maximum depth that blocks can be nested
		'max-len': ['off', 80, 4], // specify the maximum length of a line in your program
		'max-nested-callbacks': ['off', 2], // specify the maximum depth callbacks can be nested
		'max-params': ['off', 3], // limits the number of parameters that can be used in the function declaration.
		'max-statements': ['off', 10], // specify the maximum number of statement allowed in a function
		'new-cap': 'off', // require a capital letter for constructors
		'new-parens': 'off', // disallow the omission of parentheses when invoking a constructor with no arguments
		'no-array-constructor': 'off', // disallow use of the Array constructor
		'no-bitwise': 'off', // disallow use of bitwise operators
		'no-continue': 'off', // disallow use of the continue statement
		'no-inline-comments': 'off', // disallow comments inline after code
		'no-lonely-if': 'warn', // disallow if as the only statement in an else block
		'no-mixed-spaces-and-tabs': ['error', false], // disallow mixed spaces and tabs for indentation
		'no-multiple-empty-lines': ['off', {'max': 2}], // disallow multiple empty lines
		'no-negated-condition': 'warn', // disallow negated conditions
		'no-nested-ternary': 'off', // disallow nested ternary expressions
		'no-new-object': 'off', // disallow use of the Object constructor
		'no-plusplus': 'off', // disallow use of unary operators, ++ and --
		'no-restricted-syntax': 'off', // disallow use of certain syntax in code
		'no-spaced-func': 'warn', // disallow space between function identifier and application
		'no-ternary': 'off', // disallow the use of ternary operators
		'no-trailing-spaces': 'warn', // disallow trailing whitespace at the end of lines
		'no-underscore-dangle': 'off', // disallow dangling underscores in identifiers
		'no-unneeded-ternary': 'warn', // disallow the use of Boolean literals in conditional expressions
		'object-curly-spacing': ['warn', 'never'], // require or disallow padding inside curly braces
		'one-var': 'off', // allow just one var statement per function
		'operator-assignment': ['off', 'always'], // require assignment operator shorthand where possible or prohibit it entirely
		'operator-linebreak': 'off', // enforce operators to be placed before or after line breaks
		'padded-blocks': 'off', // enforce padding within blocks
		'quote-props': 'off', // require quotes around object literal property names
		'quotes': ['warn', 'single', {'allowTemplateLiterals': true}], // specify whether double or single quotes should be used
		'require-jsdoc': 'off', // Require JSDoc comment
		'semi-spacing': ['error', {'before': false, 'after': true}], // enforce spacing before and after semicolons
		'semi-style': ['error', 'last'], // enforce location of semicolons
		'semi': ['warn', 'always'], // require or disallow use of semicolons instead of ASI
		'sort-vars': 'off', // sort variables within the same declaration block
		'keyword-spacing': 'off', // require a space before/after certain keywords
		'space-before-blocks': ['off', 'always'], // require or disallow space before blocks
		'space-before-function-paren': ['error', 'never'], // require or disallow space before function opening parenthesis
		'space-in-parens': ['off', 'never'], // require or disallow spaces inside parentheses
		'space-infix-ops': 'warn', // require spaces around operators
		'space-unary-ops': ['off', {'words': true, 'nonwords': false}], // Require or disallow spaces before/after unary operators
		'spaced-comment': ['error', 'always', {'markers': ['!', '=require', '=include']}], // require or disallow a space immediately following the // or /* in a comment
		'switch-colon-spacing': 'error',
		'wrap-regex': 'off', // require regex literals to be wrapped in parentheses

		// ES6
		'arrow-body-style': 'off', // require braces in arrow function body
		'arrow-parens': 'off', // require parens in arrow function arguments
		'arrow-spacing': 'off', // require space before/after arrow function's arrow
		'constructor-super': 'off', // verify super() callings in constructors
		'generator-star-spacing': 'off', // enforce the spacing around the * in generator functions
		'no-arrow-condition': 'off', // disallow arrow functions where a condition is expected
		'no-class-assign': 'off', // disallow modifying variables of class declarations
		'no-const-assign': 'off', // disallow modifying variables that are declared using const
		'no-dupe-class-members': 'off', // disallow duplicate name in class members
		'no-this-before-super': 'off', // disallow to use this/super before super() calling in constructors.
		'no-var': 'off', // require let or const instead of var
		'object-shorthand': 'off', // require method and property shorthand syntax for object literals
		'prefer-arrow-callback': 'off', // suggest using arrow functions as callbacks
		'prefer-const': 'off', // suggest using of const declaration for variables that are never modified after declared
		'prefer-reflect': 'off', // suggest using Reflect methods where applicable
		'prefer-spread': 'off', // suggest using the spread operator instead of .apply()
		'prefer-template': 'off', // suggest using template literals instead of strings concatenation
		'require-yield': 'off', // disallow generator functions that do not have yield

		// Playwright
		'playwright/no-conditional-in-test': 'off', // Disallow conditional logic in tests
		'playwright/no-conditional-expect': 'off', // Disallow conditional logic in tests
		'playwright/valid-title': [
			'error',
			{
				'ignoreTypeOfTestName': true // Allow variables as test names
			}
		]
	}
};
