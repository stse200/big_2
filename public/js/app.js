/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! ./bootstrap */ "./resources/js/bootstrap.js");

/***/ }),

/***/ "./resources/js/bootstrap.js":
/*!***********************************!*\
  !*** ./resources/js/bootstrap.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports) {

throw new Error("Module build failed (from ./node_modules/babel-loader/lib/index.js):\nSyntaxError: /Users/stephentse/Personal_Projects/Coding/big_2_online/big_2/resources/js/bootstrap.js: Unexpected token, expected \",\" (29:17)\n\n\u001b[0m \u001b[90m 27 | \u001b[39m    \u001b[90m//forceTLS: true,\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 28 | \u001b[39m    \u001b[90m// wsHost: window.location.hostname,\u001b[39m\u001b[0m\n\u001b[0m\u001b[31m\u001b[1m>\u001b[22m\u001b[39m\u001b[90m 29 | \u001b[39m    wsHost\u001b[33m:\u001b[39m \u001b[35m47.17\u001b[39m\u001b[35m.173\u001b[39m\u001b[35m.84\u001b[39m\u001b[33m,\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m    | \u001b[39m                 \u001b[31m\u001b[1m^\u001b[22m\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 30 | \u001b[39m    wsPort\u001b[33m:\u001b[39m \u001b[35m6001\u001b[39m\u001b[33m,\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 31 | \u001b[39m    encrypted\u001b[33m:\u001b[39m \u001b[36mfalse\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 32 | \u001b[39m})\u001b[33m;\u001b[39m\u001b[0m\n    at Parser._raise (/Users/stephentse/Personal_Projects/Coding/big_2_online/big_2/node_modules/@babel/parser/lib/index.js:742:17)\n    at Parser.raiseWithData (/Users/stephentse/Personal_Projects/Coding/big_2_online/big_2/node_modules/@babel/parser/lib/index.js:735:17)\n    at Parser.raise (/Users/stephentse/Personal_Projects/Coding/big_2_online/big_2/node_modules/@babel/parser/lib/index.js:729:17)\n    at Parser.unexpected (/Users/stephentse/Personal_Projects/Coding/big_2_online/big_2/node_modules/@babel/parser/lib/index.js:8757:16)\n    at Parser.expect (/Users/stephentse/Personal_Projects/Coding/big_2_online/big_2/node_modules/@babel/parser/lib/index.js:8743:28)\n    at Parser.parseObj (/Users/stephentse/Personal_Projects/Coding/big_2_online/big_2/node_modules/@babel/parser/lib/index.js:10365:14)\n    at Parser.parseExprAtom (/Users/stephentse/Personal_Projects/Coding/big_2_online/big_2/node_modules/@babel/parser/lib/index.js:9995:28)\n    at Parser.parseExprSubscripts (/Users/stephentse/Personal_Projects/Coding/big_2_online/big_2/node_modules/@babel/parser/lib/index.js:9602:23)\n    at Parser.parseMaybeUnary (/Users/stephentse/Personal_Projects/Coding/big_2_online/big_2/node_modules/@babel/parser/lib/index.js:9582:21)\n    at Parser.parseExprOps (/Users/stephentse/Personal_Projects/Coding/big_2_online/big_2/node_modules/@babel/parser/lib/index.js:9452:23)\n    at Parser.parseMaybeConditional (/Users/stephentse/Personal_Projects/Coding/big_2_online/big_2/node_modules/@babel/parser/lib/index.js:9425:23)\n    at Parser.parseMaybeAssign (/Users/stephentse/Personal_Projects/Coding/big_2_online/big_2/node_modules/@babel/parser/lib/index.js:9380:21)\n    at Parser.parseExprListItem (/Users/stephentse/Personal_Projects/Coding/big_2_online/big_2/node_modules/@babel/parser/lib/index.js:10718:18)\n    at Parser.parseExprList (/Users/stephentse/Personal_Projects/Coding/big_2_online/big_2/node_modules/@babel/parser/lib/index.js:10692:22)\n    at Parser.parseNewArguments (/Users/stephentse/Personal_Projects/Coding/big_2_online/big_2/node_modules/@babel/parser/lib/index.js:10310:25)\n    at Parser.parseNew (/Users/stephentse/Personal_Projects/Coding/big_2_online/big_2/node_modules/@babel/parser/lib/index.js:10304:10)\n    at Parser.parseExprAtom (/Users/stephentse/Personal_Projects/Coding/big_2_online/big_2/node_modules/@babel/parser/lib/index.js:10012:21)\n    at Parser.parseExprSubscripts (/Users/stephentse/Personal_Projects/Coding/big_2_online/big_2/node_modules/@babel/parser/lib/index.js:9602:23)\n    at Parser.parseMaybeUnary (/Users/stephentse/Personal_Projects/Coding/big_2_online/big_2/node_modules/@babel/parser/lib/index.js:9582:21)\n    at Parser.parseExprOps (/Users/stephentse/Personal_Projects/Coding/big_2_online/big_2/node_modules/@babel/parser/lib/index.js:9452:23)\n    at Parser.parseMaybeConditional (/Users/stephentse/Personal_Projects/Coding/big_2_online/big_2/node_modules/@babel/parser/lib/index.js:9425:23)\n    at Parser.parseMaybeAssign (/Users/stephentse/Personal_Projects/Coding/big_2_online/big_2/node_modules/@babel/parser/lib/index.js:9380:21)\n    at Parser.parseMaybeAssign (/Users/stephentse/Personal_Projects/Coding/big_2_online/big_2/node_modules/@babel/parser/lib/index.js:9412:25)\n    at Parser.parseExpression (/Users/stephentse/Personal_Projects/Coding/big_2_online/big_2/node_modules/@babel/parser/lib/index.js:9332:23)\n    at Parser.parseStatementContent (/Users/stephentse/Personal_Projects/Coding/big_2_online/big_2/node_modules/@babel/parser/lib/index.js:11210:23)\n    at Parser.parseStatement (/Users/stephentse/Personal_Projects/Coding/big_2_online/big_2/node_modules/@babel/parser/lib/index.js:11081:17)\n    at Parser.parseBlockOrModuleBlockBody (/Users/stephentse/Personal_Projects/Coding/big_2_online/big_2/node_modules/@babel/parser/lib/index.js:11656:25)\n    at Parser.parseBlockBody (/Users/stephentse/Personal_Projects/Coding/big_2_online/big_2/node_modules/@babel/parser/lib/index.js:11642:10)\n    at Parser.parseTopLevel (/Users/stephentse/Personal_Projects/Coding/big_2_online/big_2/node_modules/@babel/parser/lib/index.js:11012:10)\n    at Parser.parse (/Users/stephentse/Personal_Projects/Coding/big_2_online/big_2/node_modules/@babel/parser/lib/index.js:12637:10)\n    at parse (/Users/stephentse/Personal_Projects/Coding/big_2_online/big_2/node_modules/@babel/parser/lib/index.js:12688:38)\n    at parser (/Users/stephentse/Personal_Projects/Coding/big_2_online/big_2/node_modules/@babel/core/lib/parser/index.js:54:34)\n    at parser.next (<anonymous>)\n    at normalizeFile (/Users/stephentse/Personal_Projects/Coding/big_2_online/big_2/node_modules/@babel/core/lib/transformation/normalize-file.js:93:38)\n    at normalizeFile.next (<anonymous>)\n    at run (/Users/stephentse/Personal_Projects/Coding/big_2_online/big_2/node_modules/@babel/core/lib/transformation/index.js:31:50)");

/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!*************************************************************!*\
  !*** multi ./resources/js/app.js ./resources/sass/app.scss ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /Users/stephentse/Personal_Projects/Coding/big_2_online/big_2/resources/js/app.js */"./resources/js/app.js");
module.exports = __webpack_require__(/*! /Users/stephentse/Personal_Projects/Coding/big_2_online/big_2/resources/sass/app.scss */"./resources/sass/app.scss");


/***/ })

/******/ });