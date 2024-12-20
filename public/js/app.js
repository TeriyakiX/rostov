/******/ (() => { // webpackBootstrap
  /******/ 	var __webpack_modules__ = ({

    /***/ "./node_modules/axios/index.js":
    /*!*************************************!*\
  !*** ./node_modules/axios/index.js ***!
  \*************************************/
    /***/ ((module, __unused_webpack_exports, __webpack_require__) => {

      module.exports = __webpack_require__(/*! ./lib/axios */ "./node_modules/axios/lib/axios.js");

      /***/ }),

    /***/ "./node_modules/axios/lib/adapters/xhr.js":
    /*!************************************************!*\
  !*** ./node_modules/axios/lib/adapters/xhr.js ***!
  \************************************************/
    /***/ ((module, __unused_webpack_exports, __webpack_require__) => {

      "use strict";


      var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");
      var settle = __webpack_require__(/*! ./../core/settle */ "./node_modules/axios/lib/core/settle.js");
      var cookies = __webpack_require__(/*! ./../helpers/cookies */ "./node_modules/axios/lib/helpers/cookies.js");
      var buildURL = __webpack_require__(/*! ./../helpers/buildURL */ "./node_modules/axios/lib/helpers/buildURL.js");
      var buildFullPath = __webpack_require__(/*! ../core/buildFullPath */ "./node_modules/axios/lib/core/buildFullPath.js");
      var parseHeaders = __webpack_require__(/*! ./../helpers/parseHeaders */ "./node_modules/axios/lib/helpers/parseHeaders.js");
      var isURLSameOrigin = __webpack_require__(/*! ./../helpers/isURLSameOrigin */ "./node_modules/axios/lib/helpers/isURLSameOrigin.js");
      var createError = __webpack_require__(/*! ../core/createError */ "./node_modules/axios/lib/core/createError.js");

      module.exports = function xhrAdapter(config) {
        return new Promise(function dispatchXhrRequest(resolve, reject) {
          var requestData = config.data;
          var requestHeaders = config.headers;
          var responseType = config.responseType;

          if (utils.isFormData(requestData)) {
            delete requestHeaders['Content-Type']; // Let the browser set it
          }

          var request = new XMLHttpRequest();

          // HTTP basic authentication
          if (config.auth) {
            var username = config.auth.username || '';
            var password = config.auth.password ? unescape(encodeURIComponent(config.auth.password)) : '';
            requestHeaders.Authorization = 'Basic ' + btoa(username + ':' + password);
          }

          var fullPath = buildFullPath(config.baseURL, config.url);
          request.open(config.method.toUpperCase(), buildURL(fullPath, config.params, config.paramsSerializer), true);

          // Set the request timeout in MS
          request.timeout = config.timeout;

          function onloadend() {
            if (!request) {
              return;
            }
            // Prepare the response
            var responseHeaders = 'getAllResponseHeaders' in request ? parseHeaders(request.getAllResponseHeaders()) : null;
            var responseData = !responseType || responseType === 'text' ||  responseType === 'json' ?
                request.responseText : request.response;
            var response = {
              data: responseData,
              status: request.status,
              statusText: request.statusText,
              headers: responseHeaders,
              config: config,
              request: request
            };

            settle(resolve, reject, response);

            // Clean up request
            request = null;
          }

          if ('onloadend' in request) {
            // Use onloadend if available
            request.onloadend = onloadend;
          } else {
            // Listen for ready state to emulate onloadend
            request.onreadystatechange = function handleLoad() {
              if (!request || request.readyState !== 4) {
                return;
              }

              // The request errored out and we didn't get a response, this will be
              // handled by onerror instead
              // With one exception: request that using file: protocol, most browsers
              // will return status as 0 even though it's a successful request
              if (request.status === 0 && !(request.responseURL && request.responseURL.indexOf('file:') === 0)) {
                return;
              }
              // readystate handler is calling before onerror or ontimeout handlers,
              // so we should call onloadend on the next 'tick'
              setTimeout(onloadend);
            };
          }

          // Handle browser request cancellation (as opposed to a manual cancellation)
          request.onabort = function handleAbort() {
            if (!request) {
              return;
            }

            reject(createError('Request aborted', config, 'ECONNABORTED', request));

            // Clean up request
            request = null;
          };

          // Handle low level network errors
          request.onerror = function handleError() {
            // Real errors are hidden from us by the browser
            // onerror should only fire if it's a network error
            reject(createError('Network Error', config, null, request));

            // Clean up request
            request = null;
          };

          // Handle timeout
          request.ontimeout = function handleTimeout() {
            var timeoutErrorMessage = 'timeout of ' + config.timeout + 'ms exceeded';
            if (config.timeoutErrorMessage) {
              timeoutErrorMessage = config.timeoutErrorMessage;
            }
            reject(createError(
                timeoutErrorMessage,
                config,
                config.transitional && config.transitional.clarifyTimeoutError ? 'ETIMEDOUT' : 'ECONNABORTED',
                request));

            // Clean up request
            request = null;
          };

          // Add xsrf header
          // This is only done if running in a standard browser environment.
          // Specifically not if we're in a web worker, or react-native.
          if (utils.isStandardBrowserEnv()) {
            // Add xsrf header
            var xsrfValue = (config.withCredentials || isURLSameOrigin(fullPath)) && config.xsrfCookieName ?
                cookies.read(config.xsrfCookieName) :
                undefined;

            if (xsrfValue) {
              requestHeaders[config.xsrfHeaderName] = xsrfValue;
            }
          }

          // Add headers to the request
          if ('setRequestHeader' in request) {
            utils.forEach(requestHeaders, function setRequestHeader(val, key) {
              if (typeof requestData === 'undefined' && key.toLowerCase() === 'content-type') {
                // Remove Content-Type if data is undefined
                delete requestHeaders[key];
              } else {
                // Otherwise add header to the request
                request.setRequestHeader(key, val);
              }
            });
          }

          // Add withCredentials to request if needed
          if (!utils.isUndefined(config.withCredentials)) {
            request.withCredentials = !!config.withCredentials;
          }

          // Add responseType to request if needed
          if (responseType && responseType !== 'json') {
            request.responseType = config.responseType;
          }

          // Handle progress if needed
          if (typeof config.onDownloadProgress === 'function') {
            request.addEventListener('progress', config.onDownloadProgress);
          }

          // Not all browsers support upload events
          if (typeof config.onUploadProgress === 'function' && request.upload) {
            request.upload.addEventListener('progress', config.onUploadProgress);
          }

          if (config.cancelToken) {
            // Handle cancellation
            config.cancelToken.promise.then(function onCanceled(cancel) {
              if (!request) {
                return;
              }

              request.abort();
              reject(cancel);
              // Clean up request
              request = null;
            });
          }

          if (!requestData) {
            requestData = null;
          }

          // Send the request
          request.send(requestData);
        });
      };


      /***/ }),

    /***/ "./node_modules/axios/lib/axios.js":
    /*!*****************************************!*\
  !*** ./node_modules/axios/lib/axios.js ***!
  \*****************************************/
    /***/ ((module, __unused_webpack_exports, __webpack_require__) => {

      "use strict";


      var utils = __webpack_require__(/*! ./utils */ "./node_modules/axios/lib/utils.js");
      var bind = __webpack_require__(/*! ./helpers/bind */ "./node_modules/axios/lib/helpers/bind.js");
      var Axios = __webpack_require__(/*! ./core/Axios */ "./node_modules/axios/lib/core/Axios.js");
      var mergeConfig = __webpack_require__(/*! ./core/mergeConfig */ "./node_modules/axios/lib/core/mergeConfig.js");
      var defaults = __webpack_require__(/*! ./defaults */ "./node_modules/axios/lib/defaults.js");

      /**
       * Create an instance of Axios
       *
       * @param {Object} defaultConfig The default config for the instance
       * @return {Axios} A new instance of Axios
       */
      function createInstance(defaultConfig) {
        var context = new Axios(defaultConfig);
        var instance = bind(Axios.prototype.request, context);

        // Copy axios.prototype to instance
        utils.extend(instance, Axios.prototype, context);

        // Copy context to instance
        utils.extend(instance, context);

        return instance;
      }

// Create the default instance to be exported
      var axios = createInstance(defaults);

// Expose Axios class to allow class inheritance
      axios.Axios = Axios;

// Factory for creating new instances
      axios.create = function create(instanceConfig) {
        return createInstance(mergeConfig(axios.defaults, instanceConfig));
      };

// Expose Cancel & CancelToken
      axios.Cancel = __webpack_require__(/*! ./cancel/Cancel */ "./node_modules/axios/lib/cancel/Cancel.js");
      axios.CancelToken = __webpack_require__(/*! ./cancel/CancelToken */ "./node_modules/axios/lib/cancel/CancelToken.js");
      axios.isCancel = __webpack_require__(/*! ./cancel/isCancel */ "./node_modules/axios/lib/cancel/isCancel.js");

// Expose all/spread
      axios.all = function all(promises) {
        return Promise.all(promises);
      };
      axios.spread = __webpack_require__(/*! ./helpers/spread */ "./node_modules/axios/lib/helpers/spread.js");

// Expose isAxiosError
      axios.isAxiosError = __webpack_require__(/*! ./helpers/isAxiosError */ "./node_modules/axios/lib/helpers/isAxiosError.js");

      module.exports = axios;

// Allow use of default import syntax in TypeScript
      module.exports["default"] = axios;


      /***/ }),

    /***/ "./node_modules/axios/lib/cancel/Cancel.js":
    /*!*************************************************!*\
  !*** ./node_modules/axios/lib/cancel/Cancel.js ***!
  \*************************************************/
    /***/ ((module) => {

      "use strict";


      /**
       * A `Cancel` is an object that is thrown when an operation is canceled.
       *
       * @class
       * @param {string=} message The message.
       */
      function Cancel(message) {
        this.message = message;
      }

      Cancel.prototype.toString = function toString() {
        return 'Cancel' + (this.message ? ': ' + this.message : '');
      };

      Cancel.prototype.__CANCEL__ = true;

      module.exports = Cancel;


      /***/ }),

    /***/ "./node_modules/axios/lib/cancel/CancelToken.js":
    /*!******************************************************!*\
  !*** ./node_modules/axios/lib/cancel/CancelToken.js ***!
  \******************************************************/
    /***/ ((module, __unused_webpack_exports, __webpack_require__) => {

      "use strict";


      var Cancel = __webpack_require__(/*! ./Cancel */ "./node_modules/axios/lib/cancel/Cancel.js");

      /**
       * A `CancelToken` is an object that can be used to request cancellation of an operation.
       *
       * @class
       * @param {Function} executor The executor function.
       */
      function CancelToken(executor) {
        if (typeof executor !== 'function') {
          throw new TypeError('executor must be a function.');
        }

        var resolvePromise;
        this.promise = new Promise(function promiseExecutor(resolve) {
          resolvePromise = resolve;
        });

        var token = this;
        executor(function cancel(message) {
          if (token.reason) {
            // Cancellation has already been requested
            return;
          }

          token.reason = new Cancel(message);
          resolvePromise(token.reason);
        });
      }

      /**
       * Throws a `Cancel` if cancellation has been requested.
       */
      CancelToken.prototype.throwIfRequested = function throwIfRequested() {
        if (this.reason) {
          throw this.reason;
        }
      };

      /**
       * Returns an object that contains a new `CancelToken` and a function that, when called,
       * cancels the `CancelToken`.
       */
      CancelToken.source = function source() {
        var cancel;
        var token = new CancelToken(function executor(c) {
          cancel = c;
        });
        return {
          token: token,
          cancel: cancel
        };
      };

      module.exports = CancelToken;


      /***/ }),

    /***/ "./node_modules/axios/lib/cancel/isCancel.js":
    /*!***************************************************!*\
  !*** ./node_modules/axios/lib/cancel/isCancel.js ***!
  \***************************************************/
    /***/ ((module) => {

      "use strict";


      module.exports = function isCancel(value) {
        return !!(value && value.__CANCEL__);
      };


      /***/ }),

    /***/ "./node_modules/axios/lib/core/Axios.js":
    /*!**********************************************!*\
  !*** ./node_modules/axios/lib/core/Axios.js ***!
  \**********************************************/
    /***/ ((module, __unused_webpack_exports, __webpack_require__) => {

      "use strict";


      var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");
      var buildURL = __webpack_require__(/*! ../helpers/buildURL */ "./node_modules/axios/lib/helpers/buildURL.js");
      var InterceptorManager = __webpack_require__(/*! ./InterceptorManager */ "./node_modules/axios/lib/core/InterceptorManager.js");
      var dispatchRequest = __webpack_require__(/*! ./dispatchRequest */ "./node_modules/axios/lib/core/dispatchRequest.js");
      var mergeConfig = __webpack_require__(/*! ./mergeConfig */ "./node_modules/axios/lib/core/mergeConfig.js");
      var validator = __webpack_require__(/*! ../helpers/validator */ "./node_modules/axios/lib/helpers/validator.js");

      var validators = validator.validators;
      /**
       * Create a new instance of Axios
       *
       * @param {Object} instanceConfig The default config for the instance
       */
      function Axios(instanceConfig) {
        this.defaults = instanceConfig;
        this.interceptors = {
          request: new InterceptorManager(),
          response: new InterceptorManager()
        };
      }

      /**
       * Dispatch a request
       *
       * @param {Object} config The config specific for this request (merged with this.defaults)
       */
      Axios.prototype.request = function request(config) {
        /*eslint no-param-reassign:0*/
        // Allow for axios('example/url'[, config]) a la fetch API
        if (typeof config === 'string') {
          config = arguments[1] || {};
          config.url = arguments[0];
        } else {
          config = config || {};
        }

        config = mergeConfig(this.defaults, config);

        // Set config.method
        if (config.method) {
          config.method = config.method.toLowerCase();
        } else if (this.defaults.method) {
          config.method = this.defaults.method.toLowerCase();
        } else {
          config.method = 'get';
        }

        var transitional = config.transitional;

        if (transitional !== undefined) {
          validator.assertOptions(transitional, {
            silentJSONParsing: validators.transitional(validators.boolean, '1.0.0'),
            forcedJSONParsing: validators.transitional(validators.boolean, '1.0.0'),
            clarifyTimeoutError: validators.transitional(validators.boolean, '1.0.0')
          }, false);
        }

        // filter out skipped interceptors
        var requestInterceptorChain = [];
        var synchronousRequestInterceptors = true;
        this.interceptors.request.forEach(function unshiftRequestInterceptors(interceptor) {
          if (typeof interceptor.runWhen === 'function' && interceptor.runWhen(config) === false) {
            return;
          }

          synchronousRequestInterceptors = synchronousRequestInterceptors && interceptor.synchronous;

          requestInterceptorChain.unshift(interceptor.fulfilled, interceptor.rejected);
        });

        var responseInterceptorChain = [];
        this.interceptors.response.forEach(function pushResponseInterceptors(interceptor) {
          responseInterceptorChain.push(interceptor.fulfilled, interceptor.rejected);
        });

        var promise;

        if (!synchronousRequestInterceptors) {
          var chain = [dispatchRequest, undefined];

          Array.prototype.unshift.apply(chain, requestInterceptorChain);
          chain = chain.concat(responseInterceptorChain);

          promise = Promise.resolve(config);
          while (chain.length) {
            promise = promise.then(chain.shift(), chain.shift());
          }

          return promise;
        }


        var newConfig = config;
        while (requestInterceptorChain.length) {
          var onFulfilled = requestInterceptorChain.shift();
          var onRejected = requestInterceptorChain.shift();
          try {
            newConfig = onFulfilled(newConfig);
          } catch (error) {
            onRejected(error);
            break;
          }
        }

        try {
          promise = dispatchRequest(newConfig);
        } catch (error) {
          return Promise.reject(error);
        }

        while (responseInterceptorChain.length) {
          promise = promise.then(responseInterceptorChain.shift(), responseInterceptorChain.shift());
        }

        return promise;
      };

      Axios.prototype.getUri = function getUri(config) {
        config = mergeConfig(this.defaults, config);
        return buildURL(config.url, config.params, config.paramsSerializer).replace(/^\?/, '');
      };

// Provide aliases for supported request methods
      utils.forEach(['delete', 'get', 'head', 'options'], function forEachMethodNoData(method) {
        /*eslint func-names:0*/
        Axios.prototype[method] = function(url, config) {
          return this.request(mergeConfig(config || {}, {
            method: method,
            url: url,
            data: (config || {}).data
          }));
        };
      });

      utils.forEach(['post', 'put', 'patch'], function forEachMethodWithData(method) {
        /*eslint func-names:0*/
        Axios.prototype[method] = function(url, data, config) {
          return this.request(mergeConfig(config || {}, {
            method: method,
            url: url,
            data: data
          }));
        };
      });

      module.exports = Axios;


      /***/ }),

    /***/ "./node_modules/axios/lib/core/InterceptorManager.js":
    /*!***********************************************************!*\
  !*** ./node_modules/axios/lib/core/InterceptorManager.js ***!
  \***********************************************************/
    /***/ ((module, __unused_webpack_exports, __webpack_require__) => {

      "use strict";


      var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");

      function InterceptorManager() {
        this.handlers = [];
      }

      /**
       * Add a new interceptor to the stack
       *
       * @param {Function} fulfilled The function to handle `then` for a `Promise`
       * @param {Function} rejected The function to handle `reject` for a `Promise`
       *
       * @return {Number} An ID used to remove interceptor later
       */
      InterceptorManager.prototype.use = function use(fulfilled, rejected, options) {
        this.handlers.push({
          fulfilled: fulfilled,
          rejected: rejected,
          synchronous: options ? options.synchronous : false,
          runWhen: options ? options.runWhen : null
        });
        return this.handlers.length - 1;
      };

      /**
       * Remove an interceptor from the stack
       *
       * @param {Number} id The ID that was returned by `use`
       */
      InterceptorManager.prototype.eject = function eject(id) {
        if (this.handlers[id]) {
          this.handlers[id] = null;
        }
      };

      /**
       * Iterate over all the registered interceptors
       *
       * This method is particularly useful for skipping over any
       * interceptors that may have become `null` calling `eject`.
       *
       * @param {Function} fn The function to call for each interceptor
       */
      InterceptorManager.prototype.forEach = function forEach(fn) {
        utils.forEach(this.handlers, function forEachHandler(h) {
          if (h !== null) {
            fn(h);
          }
        });
      };

      module.exports = InterceptorManager;


      /***/ }),

    /***/ "./node_modules/axios/lib/core/buildFullPath.js":
    /*!******************************************************!*\
  !*** ./node_modules/axios/lib/core/buildFullPath.js ***!
  \******************************************************/
    /***/ ((module, __unused_webpack_exports, __webpack_require__) => {

      "use strict";


      var isAbsoluteURL = __webpack_require__(/*! ../helpers/isAbsoluteURL */ "./node_modules/axios/lib/helpers/isAbsoluteURL.js");
      var combineURLs = __webpack_require__(/*! ../helpers/combineURLs */ "./node_modules/axios/lib/helpers/combineURLs.js");

      /**
       * Creates a new URL by combining the baseURL with the requestedURL,
       * only when the requestedURL is not already an absolute URL.
       * If the requestURL is absolute, this function returns the requestedURL untouched.
       *
       * @param {string} baseURL The base URL
       * @param {string} requestedURL Absolute or relative URL to combine
       * @returns {string} The combined full path
       */
      module.exports = function buildFullPath(baseURL, requestedURL) {
        if (baseURL && !isAbsoluteURL(requestedURL)) {
          return combineURLs(baseURL, requestedURL);
        }
        return requestedURL;
      };


      /***/ }),

    /***/ "./node_modules/axios/lib/core/createError.js":
    /*!****************************************************!*\
  !*** ./node_modules/axios/lib/core/createError.js ***!
  \****************************************************/
    /***/ ((module, __unused_webpack_exports, __webpack_require__) => {

      "use strict";


      var enhanceError = __webpack_require__(/*! ./enhanceError */ "./node_modules/axios/lib/core/enhanceError.js");

      /**
       * Create an Error with the specified message, config, error code, request and response.
       *
       * @param {string} message The error message.
       * @param {Object} config The config.
       * @param {string} [code] The error code (for example, 'ECONNABORTED').
       * @param {Object} [request] The request.
       * @param {Object} [response] The response.
       * @returns {Error} The created error.
       */
      module.exports = function createError(message, config, code, request, response) {
        var error = new Error(message);
        return enhanceError(error, config, code, request, response);
      };


      /***/ }),

    /***/ "./node_modules/axios/lib/core/dispatchRequest.js":
    /*!********************************************************!*\
  !*** ./node_modules/axios/lib/core/dispatchRequest.js ***!
  \********************************************************/
    /***/ ((module, __unused_webpack_exports, __webpack_require__) => {

      "use strict";


      var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");
      var transformData = __webpack_require__(/*! ./transformData */ "./node_modules/axios/lib/core/transformData.js");
      var isCancel = __webpack_require__(/*! ../cancel/isCancel */ "./node_modules/axios/lib/cancel/isCancel.js");
      var defaults = __webpack_require__(/*! ../defaults */ "./node_modules/axios/lib/defaults.js");

      /**
       * Throws a `Cancel` if cancellation has been requested.
       */
      function throwIfCancellationRequested(config) {
        if (config.cancelToken) {
          config.cancelToken.throwIfRequested();
        }
      }

      /**
       * Dispatch a request to the server using the configured adapter.
       *
       * @param {object} config The config that is to be used for the request
       * @returns {Promise} The Promise to be fulfilled
       */
      module.exports = function dispatchRequest(config) {
        throwIfCancellationRequested(config);

        // Ensure headers exist
        config.headers = config.headers || {};

        // Transform request data
        config.data = transformData.call(
            config,
            config.data,
            config.headers,
            config.transformRequest
        );

        // Flatten headers
        config.headers = utils.merge(
            config.headers.common || {},
            config.headers[config.method] || {},
            config.headers
        );

        utils.forEach(
            ['delete', 'get', 'head', 'post', 'put', 'patch', 'common'],
            function cleanHeaderConfig(method) {
              delete config.headers[method];
            }
        );

        var adapter = config.adapter || defaults.adapter;

        return adapter(config).then(function onAdapterResolution(response) {
          throwIfCancellationRequested(config);

          // Transform response data
          response.data = transformData.call(
              config,
              response.data,
              response.headers,
              config.transformResponse
          );

          return response;
        }, function onAdapterRejection(reason) {
          if (!isCancel(reason)) {
            throwIfCancellationRequested(config);

            // Transform response data
            if (reason && reason.response) {
              reason.response.data = transformData.call(
                  config,
                  reason.response.data,
                  reason.response.headers,
                  config.transformResponse
              );
            }
          }

          return Promise.reject(reason);
        });
      };


      /***/ }),

    /***/ "./node_modules/axios/lib/core/enhanceError.js":
    /*!*****************************************************!*\
  !*** ./node_modules/axios/lib/core/enhanceError.js ***!
  \*****************************************************/
    /***/ ((module) => {

      "use strict";


      /**
       * Update an Error with the specified config, error code, and response.
       *
       * @param {Error} error The error to update.
       * @param {Object} config The config.
       * @param {string} [code] The error code (for example, 'ECONNABORTED').
       * @param {Object} [request] The request.
       * @param {Object} [response] The response.
       * @returns {Error} The error.
       */
      module.exports = function enhanceError(error, config, code, request, response) {
        error.config = config;
        if (code) {
          error.code = code;
        }

        error.request = request;
        error.response = response;
        error.isAxiosError = true;

        error.toJSON = function toJSON() {
          return {
            // Standard
            message: this.message,
            name: this.name,
            // Microsoft
            description: this.description,
            number: this.number,
            // Mozilla
            fileName: this.fileName,
            lineNumber: this.lineNumber,
            columnNumber: this.columnNumber,
            stack: this.stack,
            // Axios
            config: this.config,
            code: this.code
          };
        };
        return error;
      };


      /***/ }),

    /***/ "./node_modules/axios/lib/core/mergeConfig.js":
    /*!****************************************************!*\
  !*** ./node_modules/axios/lib/core/mergeConfig.js ***!
  \****************************************************/
    /***/ ((module, __unused_webpack_exports, __webpack_require__) => {

      "use strict";


      var utils = __webpack_require__(/*! ../utils */ "./node_modules/axios/lib/utils.js");

      /**
       * Config-specific merge-function which creates a new config-object
       * by merging two configuration objects together.
       *
       * @param {Object} config1
       * @param {Object} config2
       * @returns {Object} New object resulting from merging config2 to config1
       */
      module.exports = function mergeConfig(config1, config2) {
        // eslint-disable-next-line no-param-reassign
        config2 = config2 || {};
        var config = {};

        var valueFromConfig2Keys = ['url', 'method', 'data'];
        var mergeDeepPropertiesKeys = ['headers', 'auth', 'proxy', 'params'];
        var defaultToConfig2Keys = [
          'baseURL', 'transformRequest', 'transformResponse', 'paramsSerializer',
          'timeout', 'timeoutMessage', 'withCredentials', 'adapter', 'responseType', 'xsrfCookieName',
          'xsrfHeaderName', 'onUploadProgress', 'onDownloadProgress', 'decompress',
          'maxContentLength', 'maxBodyLength', 'maxRedirects', 'transport', 'httpAgent',
          'httpsAgent', 'cancelToken', 'socketPath', 'responseEncoding'
        ];
        var directMergeKeys = ['validateStatus'];

        function getMergedValue(target, source) {
          if (utils.isPlainObject(target) && utils.isPlainObject(source)) {
            return utils.merge(target, source);
          } else if (utils.isPlainObject(source)) {
            return utils.merge({}, source);
          } else if (utils.isArray(source)) {
            return source.slice();
          }
          return source;
        }

        function mergeDeepProperties(prop) {
          if (!utils.isUndefined(config2[prop])) {
            config[prop] = getMergedValue(config1[prop], config2[prop]);
          } else if (!utils.isUndefined(config1[prop])) {
            config[prop] = getMergedValue(undefined, config1[prop]);
          }
        }

        utils.forEach(valueFromConfig2Keys, function valueFromConfig2(prop) {
          if (!utils.isUndefined(config2[prop])) {
            config[prop] = getMergedValue(undefined, config2[prop]);
          }
        });

        utils.forEach(mergeDeepPropertiesKeys, mergeDeepProperties);

        utils.forEach(defaultToConfig2Keys, function defaultToConfig2(prop) {
          if (!utils.isUndefined(config2[prop])) {
            config[prop] = getMergedValue(undefined, config2[prop]);
          } else if (!utils.isUndefined(config1[prop])) {
            config[prop] = getMergedValue(undefined, config1[prop]);
          }
        });

        utils.forEach(directMergeKeys, function merge(prop) {
          if (prop in config2) {
            config[prop] = getMergedValue(config1[prop], config2[prop]);
          } else if (prop in config1) {
            config[prop] = getMergedValue(undefined, config1[prop]);
          }
        });

        var axiosKeys = valueFromConfig2Keys
            .concat(mergeDeepPropertiesKeys)
            .concat(defaultToConfig2Keys)
            .concat(directMergeKeys);

        var otherKeys = Object
            .keys(config1)
            .concat(Object.keys(config2))
            .filter(function filterAxiosKeys(key) {
              return axiosKeys.indexOf(key) === -1;
            });

        utils.forEach(otherKeys, mergeDeepProperties);

        return config;
      };


      /***/ }),

    /***/ "./node_modules/axios/lib/core/settle.js":
    /*!***********************************************!*\
  !*** ./node_modules/axios/lib/core/settle.js ***!
  \***********************************************/
    /***/ ((module, __unused_webpack_exports, __webpack_require__) => {

      "use strict";


      var createError = __webpack_require__(/*! ./createError */ "./node_modules/axios/lib/core/createError.js");

      /**
       * Resolve or reject a Promise based on response status.
       *
       * @param {Function} resolve A function that resolves the promise.
       * @param {Function} reject A function that rejects the promise.
       * @param {object} response The response.
       */
      module.exports = function settle(resolve, reject, response) {
        var validateStatus = response.config.validateStatus;
        if (!response.status || !validateStatus || validateStatus(response.status)) {
          resolve(response);
        } else {
          reject(createError(
              'Request failed with status code ' + response.status,
              response.config,
              null,
              response.request,
              response
          ));
        }
      };


      /***/ }),

    /***/ "./node_modules/axios/lib/core/transformData.js":
    /*!******************************************************!*\
  !*** ./node_modules/axios/lib/core/transformData.js ***!
  \******************************************************/
    /***/ ((module, __unused_webpack_exports, __webpack_require__) => {

      "use strict";


      var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");
      var defaults = __webpack_require__(/*! ./../defaults */ "./node_modules/axios/lib/defaults.js");

      /**
       * Transform the data for a request or a response
       *
       * @param {Object|String} data The data to be transformed
       * @param {Array} headers The headers for the request or response
       * @param {Array|Function} fns A single function or Array of functions
       * @returns {*} The resulting transformed data
       */
      module.exports = function transformData(data, headers, fns) {
        var context = this || defaults;
        /*eslint no-param-reassign:0*/
        utils.forEach(fns, function transform(fn) {
          data = fn.call(context, data, headers);
        });

        return data;
      };


      /***/ }),

    /***/ "./node_modules/axios/lib/defaults.js":
    /*!********************************************!*\
  !*** ./node_modules/axios/lib/defaults.js ***!
  \********************************************/
    /***/ ((module, __unused_webpack_exports, __webpack_require__) => {

      "use strict";
      /* provided dependency */ var process = __webpack_require__(/*! process/browser.js */ "./node_modules/process/browser.js");


      var utils = __webpack_require__(/*! ./utils */ "./node_modules/axios/lib/utils.js");
      var normalizeHeaderName = __webpack_require__(/*! ./helpers/normalizeHeaderName */ "./node_modules/axios/lib/helpers/normalizeHeaderName.js");
      var enhanceError = __webpack_require__(/*! ./core/enhanceError */ "./node_modules/axios/lib/core/enhanceError.js");

      var DEFAULT_CONTENT_TYPE = {
        'Content-Type': 'application/x-www-form-urlencoded'
      };

      function setContentTypeIfUnset(headers, value) {
        if (!utils.isUndefined(headers) && utils.isUndefined(headers['Content-Type'])) {
          headers['Content-Type'] = value;
        }
      }

      function getDefaultAdapter() {
        var adapter;
        if (typeof XMLHttpRequest !== 'undefined') {
          // For browsers use XHR adapter
          adapter = __webpack_require__(/*! ./adapters/xhr */ "./node_modules/axios/lib/adapters/xhr.js");
        } else if (typeof process !== 'undefined' && Object.prototype.toString.call(process) === '[object process]') {
          // For node use HTTP adapter
          adapter = __webpack_require__(/*! ./adapters/http */ "./node_modules/axios/lib/adapters/xhr.js");
        }
        return adapter;
      }

      function stringifySafely(rawValue, parser, encoder) {
        if (utils.isString(rawValue)) {
          try {
            (parser || JSON.parse)(rawValue);
            return utils.trim(rawValue);
          } catch (e) {
            if (e.name !== 'SyntaxError') {
              throw e;
            }
          }
        }

        return (encoder || JSON.stringify)(rawValue);
      }

      var defaults = {

        transitional: {
          silentJSONParsing: true,
          forcedJSONParsing: true,
          clarifyTimeoutError: false
        },

        adapter: getDefaultAdapter(),

        transformRequest: [function transformRequest(data, headers) {
          normalizeHeaderName(headers, 'Accept');
          normalizeHeaderName(headers, 'Content-Type');

          if (utils.isFormData(data) ||
              utils.isArrayBuffer(data) ||
              utils.isBuffer(data) ||
              utils.isStream(data) ||
              utils.isFile(data) ||
              utils.isBlob(data)
          ) {
            return data;
          }
          if (utils.isArrayBufferView(data)) {
            return data.buffer;
          }
          if (utils.isURLSearchParams(data)) {
            setContentTypeIfUnset(headers, 'application/x-www-form-urlencoded;charset=utf-8');
            return data.toString();
          }
          if (utils.isObject(data) || (headers && headers['Content-Type'] === 'application/json')) {
            setContentTypeIfUnset(headers, 'application/json');
            return stringifySafely(data);
          }
          return data;
        }],

        transformResponse: [function transformResponse(data) {
          var transitional = this.transitional;
          var silentJSONParsing = transitional && transitional.silentJSONParsing;
          var forcedJSONParsing = transitional && transitional.forcedJSONParsing;
          var strictJSONParsing = !silentJSONParsing && this.responseType === 'json';

          if (strictJSONParsing || (forcedJSONParsing && utils.isString(data) && data.length)) {
            try {
              return JSON.parse(data);
            } catch (e) {
              if (strictJSONParsing) {
                if (e.name === 'SyntaxError') {
                  throw enhanceError(e, this, 'E_JSON_PARSE');
                }
                throw e;
              }
            }
          }

          return data;
        }],

        /**
         * A timeout in milliseconds to abort a request. If set to 0 (default) a
         * timeout is not created.
         */
        timeout: 0,

        xsrfCookieName: 'XSRF-TOKEN',
        xsrfHeaderName: 'X-XSRF-TOKEN',

        maxContentLength: -1,
        maxBodyLength: -1,

        validateStatus: function validateStatus(status) {
          return status >= 200 && status < 300;
        }
      };

      defaults.headers = {
        common: {
          'Accept': 'application/json, text/plain, */*'
        }
      };

      utils.forEach(['delete', 'get', 'head'], function forEachMethodNoData(method) {
        defaults.headers[method] = {};
      });

      utils.forEach(['post', 'put', 'patch'], function forEachMethodWithData(method) {
        defaults.headers[method] = utils.merge(DEFAULT_CONTENT_TYPE);
      });

      module.exports = defaults;


      /***/ }),

    /***/ "./node_modules/axios/lib/helpers/bind.js":
    /*!************************************************!*\
  !*** ./node_modules/axios/lib/helpers/bind.js ***!
  \************************************************/
    /***/ ((module) => {

      "use strict";


      module.exports = function bind(fn, thisArg) {
        return function wrap() {
          var args = new Array(arguments.length);
          for (var i = 0; i < args.length; i++) {
            args[i] = arguments[i];
          }
          return fn.apply(thisArg, args);
        };
      };


      /***/ }),

    /***/ "./node_modules/axios/lib/helpers/buildURL.js":
    /*!****************************************************!*\
  !*** ./node_modules/axios/lib/helpers/buildURL.js ***!
  \****************************************************/
    /***/ ((module, __unused_webpack_exports, __webpack_require__) => {

      "use strict";


      var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");

      function encode(val) {
        return encodeURIComponent(val).
        replace(/%3A/gi, ':').
        replace(/%24/g, '$').
        replace(/%2C/gi, ',').
        replace(/%20/g, '+').
        replace(/%5B/gi, '[').
        replace(/%5D/gi, ']');
      }

      /**
       * Build a URL by appending params to the end
       *
       * @param {string} url The base of the url (e.g., http://www.google.com)
       * @param {object} [params] The params to be appended
       * @returns {string} The formatted url
       */
      module.exports = function buildURL(url, params, paramsSerializer) {
        /*eslint no-param-reassign:0*/
        if (!params) {
          return url;
        }

        var serializedParams;
        if (paramsSerializer) {
          serializedParams = paramsSerializer(params);
        } else if (utils.isURLSearchParams(params)) {
          serializedParams = params.toString();
        } else {
          var parts = [];

          utils.forEach(params, function serialize(val, key) {
            if (val === null || typeof val === 'undefined') {
              return;
            }

            if (utils.isArray(val)) {
              key = key + '[]';
            } else {
              val = [val];
            }

            utils.forEach(val, function parseValue(v) {
              if (utils.isDate(v)) {
                v = v.toISOString();
              } else if (utils.isObject(v)) {
                v = JSON.stringify(v);
              }
              parts.push(encode(key) + '=' + encode(v));
            });
          });

          serializedParams = parts.join('&');
        }

        if (serializedParams) {
          var hashmarkIndex = url.indexOf('#');
          if (hashmarkIndex !== -1) {
            url = url.slice(0, hashmarkIndex);
          }

          url += (url.indexOf('?') === -1 ? '?' : '&') + serializedParams;
        }

        return url;
      };


      /***/ }),

    /***/ "./node_modules/axios/lib/helpers/combineURLs.js":
    /*!*******************************************************!*\
  !*** ./node_modules/axios/lib/helpers/combineURLs.js ***!
  \*******************************************************/
    /***/ ((module) => {

      "use strict";


      /**
       * Creates a new URL by combining the specified URLs
       *
       * @param {string} baseURL The base URL
       * @param {string} relativeURL The relative URL
       * @returns {string} The combined URL
       */
      module.exports = function combineURLs(baseURL, relativeURL) {
        return relativeURL
            ? baseURL.replace(/\/+$/, '') + '/' + relativeURL.replace(/^\/+/, '')
            : baseURL;
      };


      /***/ }),

    /***/ "./node_modules/axios/lib/helpers/cookies.js":
    /*!***************************************************!*\
  !*** ./node_modules/axios/lib/helpers/cookies.js ***!
  \***************************************************/
    /***/ ((module, __unused_webpack_exports, __webpack_require__) => {

      "use strict";


      var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");

      module.exports = (
          utils.isStandardBrowserEnv() ?

              // Standard browser envs support document.cookie
              (function standardBrowserEnv() {
                return {
                  write: function write(name, value, expires, path, domain, secure) {
                    var cookie = [];
                    cookie.push(name + '=' + encodeURIComponent(value));

                    if (utils.isNumber(expires)) {
                      cookie.push('expires=' + new Date(expires).toGMTString());
                    }

                    if (utils.isString(path)) {
                      cookie.push('path=' + path);
                    }

                    if (utils.isString(domain)) {
                      cookie.push('domain=' + domain);
                    }

                    if (secure === true) {
                      cookie.push('secure');
                    }

                    document.cookie = cookie.join('; ');
                  },

                  read: function read(name) {
                    var match = document.cookie.match(new RegExp('(^|;\\s*)(' + name + ')=([^;]*)'));
                    return (match ? decodeURIComponent(match[3]) : null);
                  },

                  remove: function remove(name) {
                    this.write(name, '', Date.now() - 86400000);
                  }
                };
              })() :

              // Non standard browser env (web workers, react-native) lack needed support.
              (function nonStandardBrowserEnv() {
                return {
                  write: function write() {},
                  read: function read() { return null; },
                  remove: function remove() {}
                };
              })()
      );


      /***/ }),

    /***/ "./node_modules/axios/lib/helpers/isAbsoluteURL.js":
    /*!*********************************************************!*\
  !*** ./node_modules/axios/lib/helpers/isAbsoluteURL.js ***!
  \*********************************************************/
    /***/ ((module) => {

      "use strict";


      /**
       * Determines whether the specified URL is absolute
       *
       * @param {string} url The URL to test
       * @returns {boolean} True if the specified URL is absolute, otherwise false
       */
      module.exports = function isAbsoluteURL(url) {
        // A URL is considered absolute if it begins with "<scheme>://" or "//" (protocol-relative URL).
        // RFC 3986 defines scheme name as a sequence of characters beginning with a letter and followed
        // by any combination of letters, digits, plus, period, or hyphen.
        return /^([a-z][a-z\d\+\-\.]*:)?\/\//i.test(url);
      };


      /***/ }),

    /***/ "./node_modules/axios/lib/helpers/isAxiosError.js":
    /*!********************************************************!*\
  !*** ./node_modules/axios/lib/helpers/isAxiosError.js ***!
  \********************************************************/
    /***/ ((module) => {

      "use strict";


      /**
       * Determines whether the payload is an error thrown by Axios
       *
       * @param {*} payload The value to test
       * @returns {boolean} True if the payload is an error thrown by Axios, otherwise false
       */
      module.exports = function isAxiosError(payload) {
        return (typeof payload === 'object') && (payload.isAxiosError === true);
      };


      /***/ }),

    /***/ "./node_modules/axios/lib/helpers/isURLSameOrigin.js":
    /*!***********************************************************!*\
  !*** ./node_modules/axios/lib/helpers/isURLSameOrigin.js ***!
  \***********************************************************/
    /***/ ((module, __unused_webpack_exports, __webpack_require__) => {

      "use strict";


      var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");

      module.exports = (
          utils.isStandardBrowserEnv() ?

              // Standard browser envs have full support of the APIs needed to test
              // whether the request URL is of the same origin as current location.
              (function standardBrowserEnv() {
                var msie = /(msie|trident)/i.test(navigator.userAgent);
                var urlParsingNode = document.createElement('a');
                var originURL;

                /**
                 * Parse a URL to discover it's components
                 *
                 * @param {String} url The URL to be parsed
                 * @returns {Object}
                 */
                function resolveURL(url) {
                  var href = url;

                  if (msie) {
                    // IE needs attribute set twice to normalize properties
                    urlParsingNode.setAttribute('href', href);
                    href = urlParsingNode.href;
                  }

                  urlParsingNode.setAttribute('href', href);

                  // urlParsingNode provides the UrlUtils interface - http://url.spec.whatwg.org/#urlutils
                  return {
                    href: urlParsingNode.href,
                    protocol: urlParsingNode.protocol ? urlParsingNode.protocol.replace(/:$/, '') : '',
                    host: urlParsingNode.host,
                    search: urlParsingNode.search ? urlParsingNode.search.replace(/^\?/, '') : '',
                    hash: urlParsingNode.hash ? urlParsingNode.hash.replace(/^#/, '') : '',
                    hostname: urlParsingNode.hostname,
                    port: urlParsingNode.port,
                    pathname: (urlParsingNode.pathname.charAt(0) === '/') ?
                        urlParsingNode.pathname :
                        '/' + urlParsingNode.pathname
                  };
                }

                originURL = resolveURL(window.location.href);

                /**
                 * Determine if a URL shares the same origin as the current location
                 *
                 * @param {String} requestURL The URL to test
                 * @returns {boolean} True if URL shares the same origin, otherwise false
                 */
                return function isURLSameOrigin(requestURL) {
                  var parsed = (utils.isString(requestURL)) ? resolveURL(requestURL) : requestURL;
                  return (parsed.protocol === originURL.protocol &&
                      parsed.host === originURL.host);
                };
              })() :

              // Non standard browser envs (web workers, react-native) lack needed support.
              (function nonStandardBrowserEnv() {
                return function isURLSameOrigin() {
                  return true;
                };
              })()
      );


      /***/ }),

    /***/ "./node_modules/axios/lib/helpers/normalizeHeaderName.js":
    /*!***************************************************************!*\
  !*** ./node_modules/axios/lib/helpers/normalizeHeaderName.js ***!
  \***************************************************************/
    /***/ ((module, __unused_webpack_exports, __webpack_require__) => {

      "use strict";


      var utils = __webpack_require__(/*! ../utils */ "./node_modules/axios/lib/utils.js");

      module.exports = function normalizeHeaderName(headers, normalizedName) {
        utils.forEach(headers, function processHeader(value, name) {
          if (name !== normalizedName && name.toUpperCase() === normalizedName.toUpperCase()) {
            headers[normalizedName] = value;
            delete headers[name];
          }
        });
      };


      /***/ }),

    /***/ "./node_modules/axios/lib/helpers/parseHeaders.js":
    /*!********************************************************!*\
  !*** ./node_modules/axios/lib/helpers/parseHeaders.js ***!
  \********************************************************/
    /***/ ((module, __unused_webpack_exports, __webpack_require__) => {

      "use strict";


      var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");

// Headers whose duplicates are ignored by node
// c.f. https://nodejs.org/api/http.html#http_message_headers
      var ignoreDuplicateOf = [
        'age', 'authorization', 'content-length', 'content-type', 'etag',
        'expires', 'from', 'host', 'if-modified-since', 'if-unmodified-since',
        'last-modified', 'location', 'max-forwards', 'proxy-authorization',
        'referer', 'retry-after', 'user-agent'
      ];

      /**
       * Parse headers into an object
       *
       * ```
       * Date: Wed, 27 Aug 2014 08:58:49 GMT
       * Content-Type: application/json
       * Connection: keep-alive
       * Transfer-Encoding: chunked
       * ```
       *
       * @param {String} headers Headers needing to be parsed
       * @returns {Object} Headers parsed into an object
       */
      module.exports = function parseHeaders(headers) {
        var parsed = {};
        var key;
        var val;
        var i;

        if (!headers) { return parsed; }

        utils.forEach(headers.split('\n'), function parser(line) {
          i = line.indexOf(':');
          key = utils.trim(line.substr(0, i)).toLowerCase();
          val = utils.trim(line.substr(i + 1));

          if (key) {
            if (parsed[key] && ignoreDuplicateOf.indexOf(key) >= 0) {
              return;
            }
            if (key === 'set-cookie') {
              parsed[key] = (parsed[key] ? parsed[key] : []).concat([val]);
            } else {
              parsed[key] = parsed[key] ? parsed[key] + ', ' + val : val;
            }
          }
        });

        return parsed;
      };


      /***/ }),

    /***/ "./node_modules/axios/lib/helpers/spread.js":
    /*!**************************************************!*\
  !*** ./node_modules/axios/lib/helpers/spread.js ***!
  \**************************************************/
    /***/ ((module) => {

      "use strict";


      /**
       * Syntactic sugar for invoking a function and expanding an array for arguments.
       *
       * Common use case would be to use `Function.prototype.apply`.
       *
       *  ```js
       *  function f(x, y, z) {}
       *  var args = [1, 2, 3];
       *  f.apply(null, args);
       *  ```
       *
       * With `spread` this example can be re-written.
       *
       *  ```js
       *  spread(function(x, y, z) {})([1, 2, 3]);
       *  ```
       *
       * @param {Function} callback
       * @returns {Function}
       */
      module.exports = function spread(callback) {
        return function wrap(arr) {
          return callback.apply(null, arr);
        };
      };


      /***/ }),

    /***/ "./node_modules/axios/lib/helpers/validator.js":
    /*!*****************************************************!*\
  !*** ./node_modules/axios/lib/helpers/validator.js ***!
  \*****************************************************/
    /***/ ((module, __unused_webpack_exports, __webpack_require__) => {

      "use strict";


      var pkg = __webpack_require__(/*! ./../../package.json */ "./node_modules/axios/package.json");

      var validators = {};

// eslint-disable-next-line func-names
      ['object', 'boolean', 'number', 'function', 'string', 'symbol'].forEach(function(type, i) {
        validators[type] = function validator(thing) {
          return typeof thing === type || 'a' + (i < 1 ? 'n ' : ' ') + type;
        };
      });

      var deprecatedWarnings = {};
      var currentVerArr = pkg.version.split('.');

      /**
       * Compare package versions
       * @param {string} version
       * @param {string?} thanVersion
       * @returns {boolean}
       */
      function isOlderVersion(version, thanVersion) {
        var pkgVersionArr = thanVersion ? thanVersion.split('.') : currentVerArr;
        var destVer = version.split('.');
        for (var i = 0; i < 3; i++) {
          if (pkgVersionArr[i] > destVer[i]) {
            return true;
          } else if (pkgVersionArr[i] < destVer[i]) {
            return false;
          }
        }
        return false;
      }

      /**
       * Transitional option validator
       * @param {function|boolean?} validator
       * @param {string?} version
       * @param {string} message
       * @returns {function}
       */
      validators.transitional = function transitional(validator, version, message) {
        var isDeprecated = version && isOlderVersion(version);

        function formatMessage(opt, desc) {
          return '[Axios v' + pkg.version + '] Transitional option \'' + opt + '\'' + desc + (message ? '. ' + message : '');
        }

        // eslint-disable-next-line func-names
        return function(value, opt, opts) {
          if (validator === false) {
            throw new Error(formatMessage(opt, ' has been removed in ' + version));
          }

          if (isDeprecated && !deprecatedWarnings[opt]) {
            deprecatedWarnings[opt] = true;
            // eslint-disable-next-line no-console
            console.warn(
                formatMessage(
                    opt,
                    ' has been deprecated since v' + version + ' and will be removed in the near future'
                )
            );
          }

          return validator ? validator(value, opt, opts) : true;
        };
      };

      /**
       * Assert object's properties type
       * @param {object} options
       * @param {object} schema
       * @param {boolean?} allowUnknown
       */

      function assertOptions(options, schema, allowUnknown) {
        if (typeof options !== 'object') {
          throw new TypeError('options must be an object');
        }
        var keys = Object.keys(options);
        var i = keys.length;
        while (i-- > 0) {
          var opt = keys[i];
          var validator = schema[opt];
          if (validator) {
            var value = options[opt];
            var result = value === undefined || validator(value, opt, options);
            if (result !== true) {
              throw new TypeError('option ' + opt + ' must be ' + result);
            }
            continue;
          }
          if (allowUnknown !== true) {
            throw Error('Unknown option ' + opt);
          }
        }
      }

      module.exports = {
        isOlderVersion: isOlderVersion,
        assertOptions: assertOptions,
        validators: validators
      };


      /***/ }),

    /***/ "./node_modules/axios/lib/utils.js":
    /*!*****************************************!*\
  !*** ./node_modules/axios/lib/utils.js ***!
  \*****************************************/
    /***/ ((module, __unused_webpack_exports, __webpack_require__) => {

      "use strict";


      var bind = __webpack_require__(/*! ./helpers/bind */ "./node_modules/axios/lib/helpers/bind.js");

// utils is a library of generic helper functions non-specific to axios

      var toString = Object.prototype.toString;

      /**
       * Determine if a value is an Array
       *
       * @param {Object} val The value to test
       * @returns {boolean} True if value is an Array, otherwise false
       */
      function isArray(val) {
        return toString.call(val) === '[object Array]';
      }

      /**
       * Determine if a value is undefined
       *
       * @param {Object} val The value to test
       * @returns {boolean} True if the value is undefined, otherwise false
       */
      function isUndefined(val) {
        return typeof val === 'undefined';
      }

      /**
       * Determine if a value is a Buffer
       *
       * @param {Object} val The value to test
       * @returns {boolean} True if value is a Buffer, otherwise false
       */
      function isBuffer(val) {
        return val !== null && !isUndefined(val) && val.constructor !== null && !isUndefined(val.constructor)
            && typeof val.constructor.isBuffer === 'function' && val.constructor.isBuffer(val);
      }

      /**
       * Determine if a value is an ArrayBuffer
       *
       * @param {Object} val The value to test
       * @returns {boolean} True if value is an ArrayBuffer, otherwise false
       */
      function isArrayBuffer(val) {
        return toString.call(val) === '[object ArrayBuffer]';
      }

      /**
       * Determine if a value is a FormData
       *
       * @param {Object} val The value to test
       * @returns {boolean} True if value is an FormData, otherwise false
       */
      function isFormData(val) {
        return (typeof FormData !== 'undefined') && (val instanceof FormData);
      }

      /**
       * Determine if a value is a view on an ArrayBuffer
       *
       * @param {Object} val The value to test
       * @returns {boolean} True if value is a view on an ArrayBuffer, otherwise false
       */
      function isArrayBufferView(val) {
        var result;
        if ((typeof ArrayBuffer !== 'undefined') && (ArrayBuffer.isView)) {
          result = ArrayBuffer.isView(val);
        } else {
          result = (val) && (val.buffer) && (val.buffer instanceof ArrayBuffer);
        }
        return result;
      }

      /**
       * Determine if a value is a String
       *
       * @param {Object} val The value to test
       * @returns {boolean} True if value is a String, otherwise false
       */
      function isString(val) {
        return typeof val === 'string';
      }

      /**
       * Determine if a value is a Number
       *
       * @param {Object} val The value to test
       * @returns {boolean} True if value is a Number, otherwise false
       */
      function isNumber(val) {
        return typeof val === 'number';
      }

      /**
       * Determine if a value is an Object
       *
       * @param {Object} val The value to test
       * @returns {boolean} True if value is an Object, otherwise false
       */
      function isObject(val) {
        return val !== null && typeof val === 'object';
      }

      /**
       * Determine if a value is a plain Object
       *
       * @param {Object} val The value to test
       * @return {boolean} True if value is a plain Object, otherwise false
       */
      function isPlainObject(val) {
        if (toString.call(val) !== '[object Object]') {
          return false;
        }

        var prototype = Object.getPrototypeOf(val);
        return prototype === null || prototype === Object.prototype;
      }

      /**
       * Determine if a value is a Date
       *
       * @param {Object} val The value to test
       * @returns {boolean} True if value is a Date, otherwise false
       */
      function isDate(val) {
        return toString.call(val) === '[object Date]';
      }

      /**
       * Determine if a value is a File
       *
       * @param {Object} val The value to test
       * @returns {boolean} True if value is a File, otherwise false
       */
      function isFile(val) {
        return toString.call(val) === '[object File]';
      }

      /**
       * Determine if a value is a Blob
       *
       * @param {Object} val The value to test
       * @returns {boolean} True if value is a Blob, otherwise false
       */
      function isBlob(val) {
        return toString.call(val) === '[object Blob]';
      }

      /**
       * Determine if a value is a Function
       *
       * @param {Object} val The value to test
       * @returns {boolean} True if value is a Function, otherwise false
       */
      function isFunction(val) {
        return toString.call(val) === '[object Function]';
      }

      /**
       * Determine if a value is a Stream
       *
       * @param {Object} val The value to test
       * @returns {boolean} True if value is a Stream, otherwise false
       */
      function isStream(val) {
        return isObject(val) && isFunction(val.pipe);
      }

      /**
       * Determine if a value is a URLSearchParams object
       *
       * @param {Object} val The value to test
       * @returns {boolean} True if value is a URLSearchParams object, otherwise false
       */
      function isURLSearchParams(val) {
        return typeof URLSearchParams !== 'undefined' && val instanceof URLSearchParams;
      }

      /**
       * Trim excess whitespace off the beginning and end of a string
       *
       * @param {String} str The String to trim
       * @returns {String} The String freed of excess whitespace
       */
      function trim(str) {
        return str.trim ? str.trim() : str.replace(/^\s+|\s+$/g, '');
      }

      /**
       * Determine if we're running in a standard browser environment
       *
       * This allows axios to run in a web worker, and react-native.
       * Both environments support XMLHttpRequest, but not fully standard globals.
       *
       * web workers:
       *  typeof window -> undefined
       *  typeof document -> undefined
       *
       * react-native:
       *  navigator.product -> 'ReactNative'
       * nativescript
       *  navigator.product -> 'NativeScript' or 'NS'
       */
      function isStandardBrowserEnv() {
        if (typeof navigator !== 'undefined' && (navigator.product === 'ReactNative' ||
            navigator.product === 'NativeScript' ||
            navigator.product === 'NS')) {
          return false;
        }
        return (
            typeof window !== 'undefined' &&
            typeof document !== 'undefined'
        );
      }

      /**
       * Iterate over an Array or an Object invoking a function for each item.
       *
       * If `obj` is an Array callback will be called passing
       * the value, index, and complete array for each item.
       *
       * If 'obj' is an Object callback will be called passing
       * the value, key, and complete object for each property.
       *
       * @param {Object|Array} obj The object to iterate
       * @param {Function} fn The callback to invoke for each item
       */
      function forEach(obj, fn) {
        // Don't bother if no value provided
        if (obj === null || typeof obj === 'undefined') {
          return;
        }

        // Force an array if not already something iterable
        if (typeof obj !== 'object') {
          /*eslint no-param-reassign:0*/
          obj = [obj];
        }

        if (isArray(obj)) {
          // Iterate over array values
          for (var i = 0, l = obj.length; i < l; i++) {
            fn.call(null, obj[i], i, obj);
          }
        } else {
          // Iterate over object keys
          for (var key in obj) {
            if (Object.prototype.hasOwnProperty.call(obj, key)) {
              fn.call(null, obj[key], key, obj);
            }
          }
        }
      }

      /**
       * Accepts varargs expecting each argument to be an object, then
       * immutably merges the properties of each object and returns result.
       *
       * When multiple objects contain the same key the later object in
       * the arguments list will take precedence.
       *
       * Example:
       *
       * ```js
       * var result = merge({foo: 123}, {foo: 456});
       * console.log(result.foo); // outputs 456
       * ```
       *
       * @param {Object} obj1 Object to merge
       * @returns {Object} Result of all merge properties
       */
      function merge(/* obj1, obj2, obj3, ... */) {
        var result = {};
        function assignValue(val, key) {
          if (isPlainObject(result[key]) && isPlainObject(val)) {
            result[key] = merge(result[key], val);
          } else if (isPlainObject(val)) {
            result[key] = merge({}, val);
          } else if (isArray(val)) {
            result[key] = val.slice();
          } else {
            result[key] = val;
          }
        }

        for (var i = 0, l = arguments.length; i < l; i++) {
          forEach(arguments[i], assignValue);
        }
        return result;
      }

      /**
       * Extends object a by mutably adding to it the properties of object b.
       *
       * @param {Object} a The object to be extended
       * @param {Object} b The object to copy properties from
       * @param {Object} thisArg The object to bind function to
       * @return {Object} The resulting value of object a
       */
      function extend(a, b, thisArg) {
        forEach(b, function assignValue(val, key) {
          if (thisArg && typeof val === 'function') {
            a[key] = bind(val, thisArg);
          } else {
            a[key] = val;
          }
        });
        return a;
      }

      /**
       * Remove byte order marker. This catches EF BB BF (the UTF-8 BOM)
       *
       * @param {string} content with BOM
       * @return {string} content value without BOM
       */
      function stripBOM(content) {
        if (content.charCodeAt(0) === 0xFEFF) {
          content = content.slice(1);
        }
        return content;
      }

      module.exports = {
        isArray: isArray,
        isArrayBuffer: isArrayBuffer,
        isBuffer: isBuffer,
        isFormData: isFormData,
        isArrayBufferView: isArrayBufferView,
        isString: isString,
        isNumber: isNumber,
        isObject: isObject,
        isPlainObject: isPlainObject,
        isUndefined: isUndefined,
        isDate: isDate,
        isFile: isFile,
        isBlob: isBlob,
        isFunction: isFunction,
        isStream: isStream,
        isURLSearchParams: isURLSearchParams,
        isStandardBrowserEnv: isStandardBrowserEnv,
        forEach: forEach,
        merge: merge,
        extend: extend,
        trim: trim,
        stripBOM: stripBOM
      };


      /***/ }),

    /***/ "./resources/general/services/axios.js":
    /*!*********************************************!*\
  !*** ./resources/general/services/axios.js ***!
  \*********************************************/
    /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

      "use strict";
      __webpack_require__.r(__webpack_exports__);
      /* harmony export */ __webpack_require__.d(__webpack_exports__, {
        /* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
        /* harmony export */ });
      /* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
      /* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_0__);
      function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
      function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return exports; }; var exports = {}, Op = Object.prototype, hasOwn = Op.hasOwnProperty, defineProperty = Object.defineProperty || function (obj, key, desc) { obj[key] = desc.value; }, $Symbol = "function" == typeof Symbol ? Symbol : {}, iteratorSymbol = $Symbol.iterator || "@@iterator", asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator", toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag"; function define(obj, key, value) { return Object.defineProperty(obj, key, { value: value, enumerable: !0, configurable: !0, writable: !0 }), obj[key]; } try { define({}, ""); } catch (err) { define = function define(obj, key, value) { return obj[key] = value; }; } function wrap(innerFn, outerFn, self, tryLocsList) { var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator, generator = Object.create(protoGenerator.prototype), context = new Context(tryLocsList || []); return defineProperty(generator, "_invoke", { value: makeInvokeMethod(innerFn, self, context) }), generator; } function tryCatch(fn, obj, arg) { try { return { type: "normal", arg: fn.call(obj, arg) }; } catch (err) { return { type: "throw", arg: err }; } } exports.wrap = wrap; var ContinueSentinel = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var IteratorPrototype = {}; define(IteratorPrototype, iteratorSymbol, function () { return this; }); var getProto = Object.getPrototypeOf, NativeIteratorPrototype = getProto && getProto(getProto(values([]))); NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype); var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype); function defineIteratorMethods(prototype) { ["next", "throw", "return"].forEach(function (method) { define(prototype, method, function (arg) { return this._invoke(method, arg); }); }); } function AsyncIterator(generator, PromiseImpl) { function invoke(method, arg, resolve, reject) { var record = tryCatch(generator[method], generator, arg); if ("throw" !== record.type) { var result = record.arg, value = result.value; return value && "object" == _typeof(value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) { invoke("next", value, resolve, reject); }, function (err) { invoke("throw", err, resolve, reject); }) : PromiseImpl.resolve(value).then(function (unwrapped) { result.value = unwrapped, resolve(result); }, function (error) { return invoke("throw", error, resolve, reject); }); } reject(record.arg); } var previousPromise; defineProperty(this, "_invoke", { value: function value(method, arg) { function callInvokeWithMethodAndArg() { return new PromiseImpl(function (resolve, reject) { invoke(method, arg, resolve, reject); }); } return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(innerFn, self, context) { var state = "suspendedStart"; return function (method, arg) { if ("executing" === state) throw new Error("Generator is already running"); if ("completed" === state) { if ("throw" === method) throw arg; return doneResult(); } for (context.method = method, context.arg = arg;;) { var delegate = context.delegate; if (delegate) { var delegateResult = maybeInvokeDelegate(delegate, context); if (delegateResult) { if (delegateResult === ContinueSentinel) continue; return delegateResult; } } if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) { if ("suspendedStart" === state) throw state = "completed", context.arg; context.dispatchException(context.arg); } else "return" === context.method && context.abrupt("return", context.arg); state = "executing"; var record = tryCatch(innerFn, self, context); if ("normal" === record.type) { if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue; return { value: record.arg, done: context.done }; } "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg); } }; } function maybeInvokeDelegate(delegate, context) { var methodName = context.method, method = delegate.iterator[methodName]; if (undefined === method) return context.delegate = null, "throw" === methodName && delegate.iterator["return"] && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method) || "return" !== methodName && (context.method = "throw", context.arg = new TypeError("The iterator does not provide a '" + methodName + "' method")), ContinueSentinel; var record = tryCatch(method, delegate.iterator, context.arg); if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel; var info = record.arg; return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel); } function pushTryEntry(locs) { var entry = { tryLoc: locs[0] }; 1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry); } function resetTryEntry(entry) { var record = entry.completion || {}; record.type = "normal", delete record.arg, entry.completion = record; } function Context(tryLocsList) { this.tryEntries = [{ tryLoc: "root" }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0); } function values(iterable) { if (iterable) { var iteratorMethod = iterable[iteratorSymbol]; if (iteratorMethod) return iteratorMethod.call(iterable); if ("function" == typeof iterable.next) return iterable; if (!isNaN(iterable.length)) { var i = -1, next = function next() { for (; ++i < iterable.length;) if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next; return next.value = undefined, next.done = !0, next; }; return next.next = next; } } return { next: doneResult }; } function doneResult() { return { value: undefined, done: !0 }; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, defineProperty(Gp, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), defineProperty(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) { var ctor = "function" == typeof genFun && genFun.constructor; return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name)); }, exports.mark = function (genFun) { return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun; }, exports.awrap = function (arg) { return { __await: arg }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () { return this; }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) { void 0 === PromiseImpl && (PromiseImpl = Promise); var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl); return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) { return result.done ? result.value : iter.next(); }); }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () { return this; }), define(Gp, "toString", function () { return "[object Generator]"; }), exports.keys = function (val) { var object = Object(val), keys = []; for (var key in object) keys.push(key); return keys.reverse(), function next() { for (; keys.length;) { var key = keys.pop(); if (key in object) return next.value = key, next.done = !1, next; } return next.done = !0, next; }; }, exports.values = values, Context.prototype = { constructor: Context, reset: function reset(skipTempReset) { if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined); }, stop: function stop() { this.done = !0; var rootRecord = this.tryEntries[0].completion; if ("throw" === rootRecord.type) throw rootRecord.arg; return this.rval; }, dispatchException: function dispatchException(exception) { if (this.done) throw exception; var context = this; function handle(loc, caught) { return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught; } for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i], record = entry.completion; if ("root" === entry.tryLoc) return handle("end"); if (entry.tryLoc <= this.prev) { var hasCatch = hasOwn.call(entry, "catchLoc"), hasFinally = hasOwn.call(entry, "finallyLoc"); if (hasCatch && hasFinally) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } else if (hasCatch) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); } else { if (!hasFinally) throw new Error("try statement without catch or finally"); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } } } }, abrupt: function abrupt(type, arg) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) { var finallyEntry = entry; break; } } finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null); var record = finallyEntry ? finallyEntry.completion : {}; return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record); }, complete: function complete(record, afterLoc) { if ("throw" === record.type) throw record.arg; return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel; }, finish: function finish(finallyLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel; } }, "catch": function _catch(tryLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc === tryLoc) { var record = entry.completion; if ("throw" === record.type) { var thrown = record.arg; resetTryEntry(entry); } return thrown; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(iterable, resultName, nextLoc) { return this.delegate = { iterator: values(iterable), resultName: resultName, nextLoc: nextLoc }, "next" === this.method && (this.arg = undefined), ContinueSentinel; } }, exports; }
      function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }
      function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

      /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (function (Vue) {
        (axios__WEBPACK_IMPORTED_MODULE_0___default().defaults.headers.common) = {
          'X-Requested-With': 'XMLHttpRequest',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        };
        axios__WEBPACK_IMPORTED_MODULE_0___default().interceptors.response.use(function (response) {
          return Promise.resolve(response);
        }, /*#__PURE__*/function () {
          var _ref = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee(error) {
            return _regeneratorRuntime().wrap(function _callee$(_context) {
              while (1) switch (_context.prev = _context.next) {
                case 0:
                  if (!error.response) {
                    _context.next = 18;
                    break;
                  }
                  _context.t0 = error.response.status;
                  _context.next = _context.t0 === 500 ? 4 : _context.t0 === 403 ? 6 : _context.t0 === 409 ? 8 : _context.t0 === 422 ? 10 : _context.t0 === 419 ? 11 : 15;
                  break;
                case 4:
                  Vue.$toast.error(error.response.data.message);
                  // axios.post('/log', {
                  //     code: error.response.status,
                  //     stack: error.response.data,
                  //     message: error.response.data.message
                  // });
                  return _context.abrupt("break", 16);
                case 6:
                  Vue.$toast.error('You do not have permissions to do this action.');
                  return _context.abrupt("break", 16);
                case 8:
                  Vue.$toast.error(error.response.data.message);
                  // axios.post('/log', {
                  //     code: error.response.status,
                  //     stack: error.response.data,
                  //     message: error.response.data.message
                  // });
                  return _context.abrupt("break", 16);
                case 10:
                  return _context.abrupt("break", 16);
                case 11:
                  _context.next = 13;
                  return refreshCSRFToken();
                case 13:
                  Vue.$toast.error('Ваша сессия истекла, попробуйте ещё раз.');
                  return _context.abrupt("break", 16);
                case 15:
                  Vue.$toast.error(error.response.status + ': ' + error.response.data.message);
                case 16:
                  _context.next = 19;
                  break;
                case 18:
                  Vue.$toast.error('Something went wrong. Try again later.');
                  // axios.post('/log', {
                  //     code: null,
                  //     stack: error,
                  //     message: 'Error'
                  // });
                case 19:
                  return _context.abrupt("return", Promise.reject(error));
                case 20:
                case "end":
                  return _context.stop();
              }
            }, _callee);
          }));
          return function (_x) {
            return _ref.apply(this, arguments);
          };
        }());
        window.axios = (axios__WEBPACK_IMPORTED_MODULE_0___default());
      });
      var refreshCSRFToken = /*#__PURE__*/function () {
        var _ref2 = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee2() {
          return _regeneratorRuntime().wrap(function _callee2$(_context2) {
            while (1) switch (_context2.prev = _context2.next) {
              case 0:
                _context2.next = 2;
                return axios__WEBPACK_IMPORTED_MODULE_0___default().get('/').then(function (_ref3) {
                  var data = _ref3.data;
                  var wrapper = document.createElement('div');
                  wrapper.innerHTML = data;
                  return wrapper.querySelector('meta[name=csrf-token]').getAttribute('content');
                }).then(function (token) {
                  (axios__WEBPACK_IMPORTED_MODULE_0___default().defaults.headers.common["X-CSRF-TOKEN"]) = token;
                  document.querySelector('meta[name=csrf-token]').setAttribute('content', token);
                });
              case 2:
              case "end":
                return _context2.stop();
            }
          }, _callee2);
        }));
        return function refreshCSRFToken() {
          return _ref2.apply(this, arguments);
        };
      }();

      /***/ }),

    /***/ "./resources/js/app.js":
    /*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
    /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

      "use strict";
      __webpack_require__.r(__webpack_exports__);
      /* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm.js");
      /* harmony import */ var vue_toastification__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-toastification */ "./node_modules/vue-toastification/dist/esm/index.js");
      /* harmony import */ var vue_good_table__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vue-good-table */ "./node_modules/vue-good-table/dist/vue-good-table.esm.js");
      /* harmony import */ var _general_services_axios__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./../general/services/axios */ "./resources/general/services/axios.js");
      /* harmony import */ var _components__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./components */ "./resources/js/components/index.js");
      function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
      function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }
      function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }
      function _defineProperty(obj, key, value) { key = _toPropertyKey(key); if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
      function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
      function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }



      vue__WEBPACK_IMPORTED_MODULE_1__["default"].use(vue_good_table__WEBPACK_IMPORTED_MODULE_2__["default"]);
      vue__WEBPACK_IMPORTED_MODULE_1__["default"].use(vue_toastification__WEBPACK_IMPORTED_MODULE_0__["default"], {});

      (0,_general_services_axios__WEBPACK_IMPORTED_MODULE_3__["default"])(vue__WEBPACK_IMPORTED_MODULE_1__["default"]);

      if (document.getElementById('app')) {
        var app = new vue__WEBPACK_IMPORTED_MODULE_1__["default"]({
          el: '#app',
          components: _objectSpread({}, _components__WEBPACK_IMPORTED_MODULE_4__["default"])
        });
      }

      /***/ }),

    /***/ "./resources/js/components/index.js":
    /*!******************************************!*\
  !*** ./resources/js/components/index.js ***!
  \******************************************/
    /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

      "use strict";
      __webpack_require__.r(__webpack_exports__);
      /* harmony export */ __webpack_require__.d(__webpack_exports__, {
        /* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
        /* harmony export */ });
      /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
        IndexItemsComponent: function IndexItemsComponent() {
          return __webpack_require__.e(/*! import() */ "resources_js_components_items_index_vue").then(__webpack_require__.bind(__webpack_require__, /*! ./items/index */ "./resources/js/components/items/index.vue"));
        }
      });

      /***/ }),

    /***/ "./resources/sass/app.scss":
    /*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
    /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

      "use strict";
      __webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


      /***/ }),

    /***/ "./node_modules/process/browser.js":
    /*!*****************************************!*\
  !*** ./node_modules/process/browser.js ***!
  \*****************************************/
    /***/ ((module) => {

// shim for using process in browser
      var process = module.exports = {};

// cached from whatever global is present so that test runners that stub it
// don't break things.  But we need to wrap it in a try catch in case it is
// wrapped in strict mode code which doesn't define any globals.  It's inside a
// function because try/catches deoptimize in certain engines.

      var cachedSetTimeout;
      var cachedClearTimeout;

      function defaultSetTimout() {
        throw new Error('setTimeout has not been defined');
      }
      function defaultClearTimeout () {
        throw new Error('clearTimeout has not been defined');
      }
      (function () {
        try {
          if (typeof setTimeout === 'function') {
            cachedSetTimeout = setTimeout;
          } else {
            cachedSetTimeout = defaultSetTimout;
          }
        } catch (e) {
          cachedSetTimeout = defaultSetTimout;
        }
        try {
          if (typeof clearTimeout === 'function') {
            cachedClearTimeout = clearTimeout;
          } else {
            cachedClearTimeout = defaultClearTimeout;
          }
        } catch (e) {
          cachedClearTimeout = defaultClearTimeout;
        }
      } ())
      function runTimeout(fun) {
        if (cachedSetTimeout === setTimeout) {
          //normal enviroments in sane situations
          return setTimeout(fun, 0);
        }
        // if setTimeout wasn't available but was latter defined
        if ((cachedSetTimeout === defaultSetTimout || !cachedSetTimeout) && setTimeout) {
          cachedSetTimeout = setTimeout;
          return setTimeout(fun, 0);
        }
        try {
          // when when somebody has screwed with setTimeout but no I.E. maddness
          return cachedSetTimeout(fun, 0);
        } catch(e){
          try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't trust the global object when called normally
            return cachedSetTimeout.call(null, fun, 0);
          } catch(e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error
            return cachedSetTimeout.call(this, fun, 0);
          }
        }


      }
      function runClearTimeout(marker) {
        if (cachedClearTimeout === clearTimeout) {
          //normal enviroments in sane situations
          return clearTimeout(marker);
        }
        // if clearTimeout wasn't available but was latter defined
        if ((cachedClearTimeout === defaultClearTimeout || !cachedClearTimeout) && clearTimeout) {
          cachedClearTimeout = clearTimeout;
          return clearTimeout(marker);
        }
        try {
          // when when somebody has screwed with setTimeout but no I.E. maddness
          return cachedClearTimeout(marker);
        } catch (e){
          try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't  trust the global object when called normally
            return cachedClearTimeout.call(null, marker);
          } catch (e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error.
            // Some versions of I.E. have different rules for clearTimeout vs setTimeout
            return cachedClearTimeout.call(this, marker);
          }
        }



      }
      var queue = [];
      var draining = false;
      var currentQueue;
      var queueIndex = -1;

      function cleanUpNextTick() {
        if (!draining || !currentQueue) {
          return;
        }
        draining = false;
        if (currentQueue.length) {
          queue = currentQueue.concat(queue);
        } else {
          queueIndex = -1;
        }
        if (queue.length) {
          drainQueue();
        }
      }

      function drainQueue() {
        if (draining) {
          return;
        }
        var timeout = runTimeout(cleanUpNextTick);
        draining = true;

        var len = queue.length;
        while(len) {
          currentQueue = queue;
          queue = [];
          while (++queueIndex < len) {
            if (currentQueue) {
              currentQueue[queueIndex].run();
            }
          }
          queueIndex = -1;
          len = queue.length;
        }
        currentQueue = null;
        draining = false;
        runClearTimeout(timeout);
      }

      process.nextTick = function (fun) {
        var args = new Array(arguments.length - 1);
        if (arguments.length > 1) {
          for (var i = 1; i < arguments.length; i++) {
            args[i - 1] = arguments[i];
          }
        }
        queue.push(new Item(fun, args));
        if (queue.length === 1 && !draining) {
          runTimeout(drainQueue);
        }
      };

// v8 likes predictible objects
      function Item(fun, array) {
        this.fun = fun;
        this.array = array;
      }
      Item.prototype.run = function () {
        this.fun.apply(null, this.array);
      };
      process.title = 'browser';
      process.browser = true;
      process.env = {};
      process.argv = [];
      process.version = ''; // empty string to avoid regexp issues
      process.versions = {};

      function noop() {}

      process.on = noop;
      process.addListener = noop;
      process.once = noop;
      process.off = noop;
      process.removeListener = noop;
      process.removeAllListeners = noop;
      process.emit = noop;
      process.prependListener = noop;
      process.prependOnceListener = noop;

      process.listeners = function (name) { return [] }

      process.binding = function (name) {
        throw new Error('process.binding is not supported');
      };

      process.cwd = function () { return '/' };
      process.chdir = function (dir) {
        throw new Error('process.chdir is not supported');
      };
      process.umask = function() { return 0; };


      /***/ }),

    /***/ "./node_modules/vue-good-table/dist/vue-good-table.esm.js":
    /*!****************************************************************!*\
  !*** ./node_modules/vue-good-table/dist/vue-good-table.esm.js ***!
  \****************************************************************/
    /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

      "use strict";
      __webpack_require__.r(__webpack_exports__);
      /* harmony export */ __webpack_require__.d(__webpack_exports__, {
        /* harmony export */   "VueGoodTable": () => (/* binding */ __vue_component__$6),
        /* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
        /* harmony export */ });
      /**
       * vue-good-table v2.21.11
       * (c) 2018-present xaksis <shay@crayonbits.com>
       * https://github.com/xaksis/vue-good-table
       * Released under the MIT License.
       */

      function _typeof(obj) {
        "@babel/helpers - typeof";

        if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") {
          _typeof = function (obj) {
            return typeof obj;
          };
        } else {
          _typeof = function (obj) {
            return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
          };
        }

        return _typeof(obj);
      }

      function _defineProperty(obj, key, value) {
        if (key in obj) {
          Object.defineProperty(obj, key, {
            value: value,
            enumerable: true,
            configurable: true,
            writable: true
          });
        } else {
          obj[key] = value;
        }

        return obj;
      }

      function _slicedToArray(arr, i) {
        return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest();
      }

      function _toConsumableArray(arr) {
        return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread();
      }

      function _arrayWithoutHoles(arr) {
        if (Array.isArray(arr)) return _arrayLikeToArray(arr);
      }

      function _arrayWithHoles(arr) {
        if (Array.isArray(arr)) return arr;
      }

      function _iterableToArray(iter) {
        if (typeof Symbol !== "undefined" && Symbol.iterator in Object(iter)) return Array.from(iter);
      }

      function _iterableToArrayLimit(arr, i) {
        if (typeof Symbol === "undefined" || !(Symbol.iterator in Object(arr))) return;
        var _arr = [];
        var _n = true;
        var _d = false;
        var _e = undefined;

        try {
          for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) {
            _arr.push(_s.value);

            if (i && _arr.length === i) break;
          }
        } catch (err) {
          _d = true;
          _e = err;
        } finally {
          try {
            if (!_n && _i["return"] != null) _i["return"]();
          } finally {
            if (_d) throw _e;
          }
        }

        return _arr;
      }

      function _unsupportedIterableToArray(o, minLen) {
        if (!o) return;
        if (typeof o === "string") return _arrayLikeToArray(o, minLen);
        var n = Object.prototype.toString.call(o).slice(8, -1);
        if (n === "Object" && o.constructor) n = o.constructor.name;
        if (n === "Map" || n === "Set") return Array.from(o);
        if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen);
      }

      function _arrayLikeToArray(arr, len) {
        if (len == null || len > arr.length) len = arr.length;

        for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i];

        return arr2;
      }

      function _nonIterableSpread() {
        throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
      }

      function _nonIterableRest() {
        throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
      }

      var DEFAULT_SORT_TYPE = 'asc';
      var SORT_TYPES = {
        Ascending: 'asc',
        Descending: 'desc',
        None: 'none'
      };
      var PAGINATION_MODES = {
        Pages: 'pages',
        Records: 'records'
      };
      var DEFAULT_ROWS_PER_PAGE_DROPDOWN = [10, 20, 30, 40, 50];

      var commonjsGlobal = typeof globalThis !== 'undefined' ? globalThis : typeof window !== 'undefined' ? window : typeof __webpack_require__.g !== 'undefined' ? __webpack_require__.g : typeof self !== 'undefined' ? self : {};

      function createCommonjsModule(fn, module) {
        return module = { exports: {} }, fn(module, module.exports), module.exports;
      }

      var lodash_isequal = createCommonjsModule(function (module, exports) {
        /**
         * Lodash (Custom Build) <https://lodash.com/>
         * Build: `lodash modularize exports="npm" -o ./`
         * Copyright JS Foundation and other contributors <https://js.foundation/>
         * Released under MIT license <https://lodash.com/license>
         * Based on Underscore.js 1.8.3 <http://underscorejs.org/LICENSE>
         * Copyright Jeremy Ashkenas, DocumentCloud and Investigative Reporters & Editors
         */

        /** Used as the size to enable large array optimizations. */
        var LARGE_ARRAY_SIZE = 200;

        /** Used to stand-in for `undefined` hash values. */
        var HASH_UNDEFINED = '__lodash_hash_undefined__';

        /** Used to compose bitmasks for value comparisons. */
        var COMPARE_PARTIAL_FLAG = 1,
            COMPARE_UNORDERED_FLAG = 2;

        /** Used as references for various `Number` constants. */
        var MAX_SAFE_INTEGER = 9007199254740991;

        /** `Object#toString` result references. */
        var argsTag = '[object Arguments]',
            arrayTag = '[object Array]',
            asyncTag = '[object AsyncFunction]',
            boolTag = '[object Boolean]',
            dateTag = '[object Date]',
            errorTag = '[object Error]',
            funcTag = '[object Function]',
            genTag = '[object GeneratorFunction]',
            mapTag = '[object Map]',
            numberTag = '[object Number]',
            nullTag = '[object Null]',
            objectTag = '[object Object]',
            promiseTag = '[object Promise]',
            proxyTag = '[object Proxy]',
            regexpTag = '[object RegExp]',
            setTag = '[object Set]',
            stringTag = '[object String]',
            symbolTag = '[object Symbol]',
            undefinedTag = '[object Undefined]',
            weakMapTag = '[object WeakMap]';

        var arrayBufferTag = '[object ArrayBuffer]',
            dataViewTag = '[object DataView]',
            float32Tag = '[object Float32Array]',
            float64Tag = '[object Float64Array]',
            int8Tag = '[object Int8Array]',
            int16Tag = '[object Int16Array]',
            int32Tag = '[object Int32Array]',
            uint8Tag = '[object Uint8Array]',
            uint8ClampedTag = '[object Uint8ClampedArray]',
            uint16Tag = '[object Uint16Array]',
            uint32Tag = '[object Uint32Array]';

        /**
         * Used to match `RegExp`
         * [syntax characters](http://ecma-international.org/ecma-262/7.0/#sec-patterns).
         */
        var reRegExpChar = /[\\^$.*+?()[\]{}|]/g;

        /** Used to detect host constructors (Safari). */
        var reIsHostCtor = /^\[object .+?Constructor\]$/;

        /** Used to detect unsigned integer values. */
        var reIsUint = /^(?:0|[1-9]\d*)$/;

        /** Used to identify `toStringTag` values of typed arrays. */
        var typedArrayTags = {};
        typedArrayTags[float32Tag] = typedArrayTags[float64Tag] =
            typedArrayTags[int8Tag] = typedArrayTags[int16Tag] =
                typedArrayTags[int32Tag] = typedArrayTags[uint8Tag] =
                    typedArrayTags[uint8ClampedTag] = typedArrayTags[uint16Tag] =
                        typedArrayTags[uint32Tag] = true;
        typedArrayTags[argsTag] = typedArrayTags[arrayTag] =
            typedArrayTags[arrayBufferTag] = typedArrayTags[boolTag] =
                typedArrayTags[dataViewTag] = typedArrayTags[dateTag] =
                    typedArrayTags[errorTag] = typedArrayTags[funcTag] =
                        typedArrayTags[mapTag] = typedArrayTags[numberTag] =
                            typedArrayTags[objectTag] = typedArrayTags[regexpTag] =
                                typedArrayTags[setTag] = typedArrayTags[stringTag] =
                                    typedArrayTags[weakMapTag] = false;

        /** Detect free variable `global` from Node.js. */
        var freeGlobal = typeof commonjsGlobal == 'object' && commonjsGlobal && commonjsGlobal.Object === Object && commonjsGlobal;

        /** Detect free variable `self`. */
        var freeSelf = typeof self == 'object' && self && self.Object === Object && self;

        /** Used as a reference to the global object. */
        var root = freeGlobal || freeSelf || Function('return this')();

        /** Detect free variable `exports`. */
        var freeExports =  exports && !exports.nodeType && exports;

        /** Detect free variable `module`. */
        var freeModule = freeExports && 'object' == 'object' && module && !module.nodeType && module;

        /** Detect the popular CommonJS extension `module.exports`. */
        var moduleExports = freeModule && freeModule.exports === freeExports;

        /** Detect free variable `process` from Node.js. */
        var freeProcess = moduleExports && freeGlobal.process;

        /** Used to access faster Node.js helpers. */
        var nodeUtil = (function() {
          try {
            return freeProcess && freeProcess.binding && freeProcess.binding('util');
          } catch (e) {}
        }());

        /* Node.js helper references. */
        var nodeIsTypedArray = nodeUtil && nodeUtil.isTypedArray;

        /**
         * A specialized version of `_.filter` for arrays without support for
         * iteratee shorthands.
         *
         * @private
         * @param {Array} [array] The array to iterate over.
         * @param {Function} predicate The function invoked per iteration.
         * @returns {Array} Returns the new filtered array.
         */
        function arrayFilter(array, predicate) {
          var index = -1,
              length = array == null ? 0 : array.length,
              resIndex = 0,
              result = [];

          while (++index < length) {
            var value = array[index];
            if (predicate(value, index, array)) {
              result[resIndex++] = value;
            }
          }
          return result;
        }

        /**
         * Appends the elements of `values` to `array`.
         *
         * @private
         * @param {Array} array The array to modify.
         * @param {Array} values The values to append.
         * @returns {Array} Returns `array`.
         */
        function arrayPush(array, values) {
          var index = -1,
              length = values.length,
              offset = array.length;

          while (++index < length) {
            array[offset + index] = values[index];
          }
          return array;
        }

        /**
         * A specialized version of `_.some` for arrays without support for iteratee
         * shorthands.
         *
         * @private
         * @param {Array} [array] The array to iterate over.
         * @param {Function} predicate The function invoked per iteration.
         * @returns {boolean} Returns `true` if any element passes the predicate check,
         *  else `false`.
         */
        function arraySome(array, predicate) {
          var index = -1,
              length = array == null ? 0 : array.length;

          while (++index < length) {
            if (predicate(array[index], index, array)) {
              return true;
            }
          }
          return false;
        }

        /**
         * The base implementation of `_.times` without support for iteratee shorthands
         * or max array length checks.
         *
         * @private
         * @param {number} n The number of times to invoke `iteratee`.
         * @param {Function} iteratee The function invoked per iteration.
         * @returns {Array} Returns the array of results.
         */
        function baseTimes(n, iteratee) {
          var index = -1,
              result = Array(n);

          while (++index < n) {
            result[index] = iteratee(index);
          }
          return result;
        }

        /**
         * The base implementation of `_.unary` without support for storing metadata.
         *
         * @private
         * @param {Function} func The function to cap arguments for.
         * @returns {Function} Returns the new capped function.
         */
        function baseUnary(func) {
          return function(value) {
            return func(value);
          };
        }

        /**
         * Checks if a `cache` value for `key` exists.
         *
         * @private
         * @param {Object} cache The cache to query.
         * @param {string} key The key of the entry to check.
         * @returns {boolean} Returns `true` if an entry for `key` exists, else `false`.
         */
        function cacheHas(cache, key) {
          return cache.has(key);
        }

        /**
         * Gets the value at `key` of `object`.
         *
         * @private
         * @param {Object} [object] The object to query.
         * @param {string} key The key of the property to get.
         * @returns {*} Returns the property value.
         */
        function getValue(object, key) {
          return object == null ? undefined : object[key];
        }

        /**
         * Converts `map` to its key-value pairs.
         *
         * @private
         * @param {Object} map The map to convert.
         * @returns {Array} Returns the key-value pairs.
         */
        function mapToArray(map) {
          var index = -1,
              result = Array(map.size);

          map.forEach(function(value, key) {
            result[++index] = [key, value];
          });
          return result;
        }

        /**
         * Creates a unary function that invokes `func` with its argument transformed.
         *
         * @private
         * @param {Function} func The function to wrap.
         * @param {Function} transform The argument transform.
         * @returns {Function} Returns the new function.
         */
        function overArg(func, transform) {
          return function(arg) {
            return func(transform(arg));
          };
        }

        /**
         * Converts `set` to an array of its values.
         *
         * @private
         * @param {Object} set The set to convert.
         * @returns {Array} Returns the values.
         */
        function setToArray(set) {
          var index = -1,
              result = Array(set.size);

          set.forEach(function(value) {
            result[++index] = value;
          });
          return result;
        }

        /** Used for built-in method references. */
        var arrayProto = Array.prototype,
            funcProto = Function.prototype,
            objectProto = Object.prototype;

        /** Used to detect overreaching core-js shims. */
        var coreJsData = root['__core-js_shared__'];

        /** Used to resolve the decompiled source of functions. */
        var funcToString = funcProto.toString;

        /** Used to check objects for own properties. */
        var hasOwnProperty = objectProto.hasOwnProperty;

        /** Used to detect methods masquerading as native. */
        var maskSrcKey = (function() {
          var uid = /[^.]+$/.exec(coreJsData && coreJsData.keys && coreJsData.keys.IE_PROTO || '');
          return uid ? ('Symbol(src)_1.' + uid) : '';
        }());

        /**
         * Used to resolve the
         * [`toStringTag`](http://ecma-international.org/ecma-262/7.0/#sec-object.prototype.tostring)
         * of values.
         */
        var nativeObjectToString = objectProto.toString;

        /** Used to detect if a method is native. */
        var reIsNative = RegExp('^' +
            funcToString.call(hasOwnProperty).replace(reRegExpChar, '\\$&')
                .replace(/hasOwnProperty|(function).*?(?=\\\()| for .+?(?=\\\])/g, '$1.*?') + '$'
        );

        /** Built-in value references. */
        var Buffer = moduleExports ? root.Buffer : undefined,
            Symbol = root.Symbol,
            Uint8Array = root.Uint8Array,
            propertyIsEnumerable = objectProto.propertyIsEnumerable,
            splice = arrayProto.splice,
            symToStringTag = Symbol ? Symbol.toStringTag : undefined;

        /* Built-in method references for those with the same name as other `lodash` methods. */
        var nativeGetSymbols = Object.getOwnPropertySymbols,
            nativeIsBuffer = Buffer ? Buffer.isBuffer : undefined,
            nativeKeys = overArg(Object.keys, Object);

        /* Built-in method references that are verified to be native. */
        var DataView = getNative(root, 'DataView'),
            Map = getNative(root, 'Map'),
            Promise = getNative(root, 'Promise'),
            Set = getNative(root, 'Set'),
            WeakMap = getNative(root, 'WeakMap'),
            nativeCreate = getNative(Object, 'create');

        /** Used to detect maps, sets, and weakmaps. */
        var dataViewCtorString = toSource(DataView),
            mapCtorString = toSource(Map),
            promiseCtorString = toSource(Promise),
            setCtorString = toSource(Set),
            weakMapCtorString = toSource(WeakMap);

        /** Used to convert symbols to primitives and strings. */
        var symbolProto = Symbol ? Symbol.prototype : undefined,
            symbolValueOf = symbolProto ? symbolProto.valueOf : undefined;

        /**
         * Creates a hash object.
         *
         * @private
         * @constructor
         * @param {Array} [entries] The key-value pairs to cache.
         */
        function Hash(entries) {
          var index = -1,
              length = entries == null ? 0 : entries.length;

          this.clear();
          while (++index < length) {
            var entry = entries[index];
            this.set(entry[0], entry[1]);
          }
        }

        /**
         * Removes all key-value entries from the hash.
         *
         * @private
         * @name clear
         * @memberOf Hash
         */
        function hashClear() {
          this.__data__ = nativeCreate ? nativeCreate(null) : {};
          this.size = 0;
        }

        /**
         * Removes `key` and its value from the hash.
         *
         * @private
         * @name delete
         * @memberOf Hash
         * @param {Object} hash The hash to modify.
         * @param {string} key The key of the value to remove.
         * @returns {boolean} Returns `true` if the entry was removed, else `false`.
         */
        function hashDelete(key) {
          var result = this.has(key) && delete this.__data__[key];
          this.size -= result ? 1 : 0;
          return result;
        }

        /**
         * Gets the hash value for `key`.
         *
         * @private
         * @name get
         * @memberOf Hash
         * @param {string} key The key of the value to get.
         * @returns {*} Returns the entry value.
         */
        function hashGet(key) {
          var data = this.__data__;
          if (nativeCreate) {
            var result = data[key];
            return result === HASH_UNDEFINED ? undefined : result;
          }
          return hasOwnProperty.call(data, key) ? data[key] : undefined;
        }

        /**
         * Checks if a hash value for `key` exists.
         *
         * @private
         * @name has
         * @memberOf Hash
         * @param {string} key The key of the entry to check.
         * @returns {boolean} Returns `true` if an entry for `key` exists, else `false`.
         */
        function hashHas(key) {
          var data = this.__data__;
          return nativeCreate ? (data[key] !== undefined) : hasOwnProperty.call(data, key);
        }

        /**
         * Sets the hash `key` to `value`.
         *
         * @private
         * @name set
         * @memberOf Hash
         * @param {string} key The key of the value to set.
         * @param {*} value The value to set.
         * @returns {Object} Returns the hash instance.
         */
        function hashSet(key, value) {
          var data = this.__data__;
          this.size += this.has(key) ? 0 : 1;
          data[key] = (nativeCreate && value === undefined) ? HASH_UNDEFINED : value;
          return this;
        }

// Add methods to `Hash`.
        Hash.prototype.clear = hashClear;
        Hash.prototype['delete'] = hashDelete;
        Hash.prototype.get = hashGet;
        Hash.prototype.has = hashHas;
        Hash.prototype.set = hashSet;

        /**
         * Creates an list cache object.
         *
         * @private
         * @constructor
         * @param {Array} [entries] The key-value pairs to cache.
         */
        function ListCache(entries) {
          var index = -1,
              length = entries == null ? 0 : entries.length;

          this.clear();
          while (++index < length) {
            var entry = entries[index];
            this.set(entry[0], entry[1]);
          }
        }

        /**
         * Removes all key-value entries from the list cache.
         *
         * @private
         * @name clear
         * @memberOf ListCache
         */
        function listCacheClear() {
          this.__data__ = [];
          this.size = 0;
        }

        /**
         * Removes `key` and its value from the list cache.
         *
         * @private
         * @name delete
         * @memberOf ListCache
         * @param {string} key The key of the value to remove.
         * @returns {boolean} Returns `true` if the entry was removed, else `false`.
         */
        function listCacheDelete(key) {
          var data = this.__data__,
              index = assocIndexOf(data, key);

          if (index < 0) {
            return false;
          }
          var lastIndex = data.length - 1;
          if (index == lastIndex) {
            data.pop();
          } else {
            splice.call(data, index, 1);
          }
          --this.size;
          return true;
        }

        /**
         * Gets the list cache value for `key`.
         *
         * @private
         * @name get
         * @memberOf ListCache
         * @param {string} key The key of the value to get.
         * @returns {*} Returns the entry value.
         */
        function listCacheGet(key) {
          var data = this.__data__,
              index = assocIndexOf(data, key);

          return index < 0 ? undefined : data[index][1];
        }

        /**
         * Checks if a list cache value for `key` exists.
         *
         * @private
         * @name has
         * @memberOf ListCache
         * @param {string} key The key of the entry to check.
         * @returns {boolean} Returns `true` if an entry for `key` exists, else `false`.
         */
        function listCacheHas(key) {
          return assocIndexOf(this.__data__, key) > -1;
        }

        /**
         * Sets the list cache `key` to `value`.
         *
         * @private
         * @name set
         * @memberOf ListCache
         * @param {string} key The key of the value to set.
         * @param {*} value The value to set.
         * @returns {Object} Returns the list cache instance.
         */
        function listCacheSet(key, value) {
          var data = this.__data__,
              index = assocIndexOf(data, key);

          if (index < 0) {
            ++this.size;
            data.push([key, value]);
          } else {
            data[index][1] = value;
          }
          return this;
        }

// Add methods to `ListCache`.
        ListCache.prototype.clear = listCacheClear;
        ListCache.prototype['delete'] = listCacheDelete;
        ListCache.prototype.get = listCacheGet;
        ListCache.prototype.has = listCacheHas;
        ListCache.prototype.set = listCacheSet;

        /**
         * Creates a map cache object to store key-value pairs.
         *
         * @private
         * @constructor
         * @param {Array} [entries] The key-value pairs to cache.
         */
        function MapCache(entries) {
          var index = -1,
              length = entries == null ? 0 : entries.length;

          this.clear();
          while (++index < length) {
            var entry = entries[index];
            this.set(entry[0], entry[1]);
          }
        }

        /**
         * Removes all key-value entries from the map.
         *
         * @private
         * @name clear
         * @memberOf MapCache
         */
        function mapCacheClear() {
          this.size = 0;
          this.__data__ = {
            'hash': new Hash,
            'map': new (Map || ListCache),
            'string': new Hash
          };
        }

        /**
         * Removes `key` and its value from the map.
         *
         * @private
         * @name delete
         * @memberOf MapCache
         * @param {string} key The key of the value to remove.
         * @returns {boolean} Returns `true` if the entry was removed, else `false`.
         */
        function mapCacheDelete(key) {
          var result = getMapData(this, key)['delete'](key);
          this.size -= result ? 1 : 0;
          return result;
        }

        /**
         * Gets the map value for `key`.
         *
         * @private
         * @name get
         * @memberOf MapCache
         * @param {string} key The key of the value to get.
         * @returns {*} Returns the entry value.
         */
        function mapCacheGet(key) {
          return getMapData(this, key).get(key);
        }

        /**
         * Checks if a map value for `key` exists.
         *
         * @private
         * @name has
         * @memberOf MapCache
         * @param {string} key The key of the entry to check.
         * @returns {boolean} Returns `true` if an entry for `key` exists, else `false`.
         */
        function mapCacheHas(key) {
          return getMapData(this, key).has(key);
        }

        /**
         * Sets the map `key` to `value`.
         *
         * @private
         * @name set
         * @memberOf MapCache
         * @param {string} key The key of the value to set.
         * @param {*} value The value to set.
         * @returns {Object} Returns the map cache instance.
         */
        function mapCacheSet(key, value) {
          var data = getMapData(this, key),
              size = data.size;

          data.set(key, value);
          this.size += data.size == size ? 0 : 1;
          return this;
        }

// Add methods to `MapCache`.
        MapCache.prototype.clear = mapCacheClear;
        MapCache.prototype['delete'] = mapCacheDelete;
        MapCache.prototype.get = mapCacheGet;
        MapCache.prototype.has = mapCacheHas;
        MapCache.prototype.set = mapCacheSet;

        /**
         *
         * Creates an array cache object to store unique values.
         *
         * @private
         * @constructor
         * @param {Array} [values] The values to cache.
         */
        function SetCache(values) {
          var index = -1,
              length = values == null ? 0 : values.length;

          this.__data__ = new MapCache;
          while (++index < length) {
            this.add(values[index]);
          }
        }

        /**
         * Adds `value` to the array cache.
         *
         * @private
         * @name add
         * @memberOf SetCache
         * @alias push
         * @param {*} value The value to cache.
         * @returns {Object} Returns the cache instance.
         */
        function setCacheAdd(value) {
          this.__data__.set(value, HASH_UNDEFINED);
          return this;
        }

        /**
         * Checks if `value` is in the array cache.
         *
         * @private
         * @name has
         * @memberOf SetCache
         * @param {*} value The value to search for.
         * @returns {number} Returns `true` if `value` is found, else `false`.
         */
        function setCacheHas(value) {
          return this.__data__.has(value);
        }

// Add methods to `SetCache`.
        SetCache.prototype.add = SetCache.prototype.push = setCacheAdd;
        SetCache.prototype.has = setCacheHas;

        /**
         * Creates a stack cache object to store key-value pairs.
         *
         * @private
         * @constructor
         * @param {Array} [entries] The key-value pairs to cache.
         */
        function Stack(entries) {
          var data = this.__data__ = new ListCache(entries);
          this.size = data.size;
        }

        /**
         * Removes all key-value entries from the stack.
         *
         * @private
         * @name clear
         * @memberOf Stack
         */
        function stackClear() {
          this.__data__ = new ListCache;
          this.size = 0;
        }

        /**
         * Removes `key` and its value from the stack.
         *
         * @private
         * @name delete
         * @memberOf Stack
         * @param {string} key The key of the value to remove.
         * @returns {boolean} Returns `true` if the entry was removed, else `false`.
         */
        function stackDelete(key) {
          var data = this.__data__,
              result = data['delete'](key);

          this.size = data.size;
          return result;
        }

        /**
         * Gets the stack value for `key`.
         *
         * @private
         * @name get
         * @memberOf Stack
         * @param {string} key The key of the value to get.
         * @returns {*} Returns the entry value.
         */
        function stackGet(key) {
          return this.__data__.get(key);
        }

        /**
         * Checks if a stack value for `key` exists.
         *
         * @private
         * @name has
         * @memberOf Stack
         * @param {string} key The key of the entry to check.
         * @returns {boolean} Returns `true` if an entry for `key` exists, else `false`.
         */
        function stackHas(key) {
          return this.__data__.has(key);
        }

        /**
         * Sets the stack `key` to `value`.
         *
         * @private
         * @name set
         * @memberOf Stack
         * @param {string} key The key of the value to set.
         * @param {*} value The value to set.
         * @returns {Object} Returns the stack cache instance.
         */
        function stackSet(key, value) {
          var data = this.__data__;
          if (data instanceof ListCache) {
            var pairs = data.__data__;
            if (!Map || (pairs.length < LARGE_ARRAY_SIZE - 1)) {
              pairs.push([key, value]);
              this.size = ++data.size;
              return this;
            }
            data = this.__data__ = new MapCache(pairs);
          }
          data.set(key, value);
          this.size = data.size;
          return this;
        }

// Add methods to `Stack`.
        Stack.prototype.clear = stackClear;
        Stack.prototype['delete'] = stackDelete;
        Stack.prototype.get = stackGet;
        Stack.prototype.has = stackHas;
        Stack.prototype.set = stackSet;

        /**
         * Creates an array of the enumerable property names of the array-like `value`.
         *
         * @private
         * @param {*} value The value to query.
         * @param {boolean} inherited Specify returning inherited property names.
         * @returns {Array} Returns the array of property names.
         */
        function arrayLikeKeys(value, inherited) {
          var isArr = isArray(value),
              isArg = !isArr && isArguments(value),
              isBuff = !isArr && !isArg && isBuffer(value),
              isType = !isArr && !isArg && !isBuff && isTypedArray(value),
              skipIndexes = isArr || isArg || isBuff || isType,
              result = skipIndexes ? baseTimes(value.length, String) : [],
              length = result.length;

          for (var key in value) {
            if ((inherited || hasOwnProperty.call(value, key)) &&
                !(skipIndexes && (
                    // Safari 9 has enumerable `arguments.length` in strict mode.
                    key == 'length' ||
                    // Node.js 0.10 has enumerable non-index properties on buffers.
                    (isBuff && (key == 'offset' || key == 'parent')) ||
                    // PhantomJS 2 has enumerable non-index properties on typed arrays.
                    (isType && (key == 'buffer' || key == 'byteLength' || key == 'byteOffset')) ||
                    // Skip index properties.
                    isIndex(key, length)
                ))) {
              result.push(key);
            }
          }
          return result;
        }

        /**
         * Gets the index at which the `key` is found in `array` of key-value pairs.
         *
         * @private
         * @param {Array} array The array to inspect.
         * @param {*} key The key to search for.
         * @returns {number} Returns the index of the matched value, else `-1`.
         */
        function assocIndexOf(array, key) {
          var length = array.length;
          while (length--) {
            if (eq(array[length][0], key)) {
              return length;
            }
          }
          return -1;
        }

        /**
         * The base implementation of `getAllKeys` and `getAllKeysIn` which uses
         * `keysFunc` and `symbolsFunc` to get the enumerable property names and
         * symbols of `object`.
         *
         * @private
         * @param {Object} object The object to query.
         * @param {Function} keysFunc The function to get the keys of `object`.
         * @param {Function} symbolsFunc The function to get the symbols of `object`.
         * @returns {Array} Returns the array of property names and symbols.
         */
        function baseGetAllKeys(object, keysFunc, symbolsFunc) {
          var result = keysFunc(object);
          return isArray(object) ? result : arrayPush(result, symbolsFunc(object));
        }

        /**
         * The base implementation of `getTag` without fallbacks for buggy environments.
         *
         * @private
         * @param {*} value The value to query.
         * @returns {string} Returns the `toStringTag`.
         */
        function baseGetTag(value) {
          if (value == null) {
            return value === undefined ? undefinedTag : nullTag;
          }
          return (symToStringTag && symToStringTag in Object(value))
              ? getRawTag(value)
              : objectToString(value);
        }

        /**
         * The base implementation of `_.isArguments`.
         *
         * @private
         * @param {*} value The value to check.
         * @returns {boolean} Returns `true` if `value` is an `arguments` object,
         */
        function baseIsArguments(value) {
          return isObjectLike(value) && baseGetTag(value) == argsTag;
        }

        /**
         * The base implementation of `_.isEqual` which supports partial comparisons
         * and tracks traversed objects.
         *
         * @private
         * @param {*} value The value to compare.
         * @param {*} other The other value to compare.
         * @param {boolean} bitmask The bitmask flags.
         *  1 - Unordered comparison
         *  2 - Partial comparison
         * @param {Function} [customizer] The function to customize comparisons.
         * @param {Object} [stack] Tracks traversed `value` and `other` objects.
         * @returns {boolean} Returns `true` if the values are equivalent, else `false`.
         */
        function baseIsEqual(value, other, bitmask, customizer, stack) {
          if (value === other) {
            return true;
          }
          if (value == null || other == null || (!isObjectLike(value) && !isObjectLike(other))) {
            return value !== value && other !== other;
          }
          return baseIsEqualDeep(value, other, bitmask, customizer, baseIsEqual, stack);
        }

        /**
         * A specialized version of `baseIsEqual` for arrays and objects which performs
         * deep comparisons and tracks traversed objects enabling objects with circular
         * references to be compared.
         *
         * @private
         * @param {Object} object The object to compare.
         * @param {Object} other The other object to compare.
         * @param {number} bitmask The bitmask flags. See `baseIsEqual` for more details.
         * @param {Function} customizer The function to customize comparisons.
         * @param {Function} equalFunc The function to determine equivalents of values.
         * @param {Object} [stack] Tracks traversed `object` and `other` objects.
         * @returns {boolean} Returns `true` if the objects are equivalent, else `false`.
         */
        function baseIsEqualDeep(object, other, bitmask, customizer, equalFunc, stack) {
          var objIsArr = isArray(object),
              othIsArr = isArray(other),
              objTag = objIsArr ? arrayTag : getTag(object),
              othTag = othIsArr ? arrayTag : getTag(other);

          objTag = objTag == argsTag ? objectTag : objTag;
          othTag = othTag == argsTag ? objectTag : othTag;

          var objIsObj = objTag == objectTag,
              othIsObj = othTag == objectTag,
              isSameTag = objTag == othTag;

          if (isSameTag && isBuffer(object)) {
            if (!isBuffer(other)) {
              return false;
            }
            objIsArr = true;
            objIsObj = false;
          }
          if (isSameTag && !objIsObj) {
            stack || (stack = new Stack);
            return (objIsArr || isTypedArray(object))
                ? equalArrays(object, other, bitmask, customizer, equalFunc, stack)
                : equalByTag(object, other, objTag, bitmask, customizer, equalFunc, stack);
          }
          if (!(bitmask & COMPARE_PARTIAL_FLAG)) {
            var objIsWrapped = objIsObj && hasOwnProperty.call(object, '__wrapped__'),
                othIsWrapped = othIsObj && hasOwnProperty.call(other, '__wrapped__');

            if (objIsWrapped || othIsWrapped) {
              var objUnwrapped = objIsWrapped ? object.value() : object,
                  othUnwrapped = othIsWrapped ? other.value() : other;

              stack || (stack = new Stack);
              return equalFunc(objUnwrapped, othUnwrapped, bitmask, customizer, stack);
            }
          }
          if (!isSameTag) {
            return false;
          }
          stack || (stack = new Stack);
          return equalObjects(object, other, bitmask, customizer, equalFunc, stack);
        }

        /**
         * The base implementation of `_.isNative` without bad shim checks.
         *
         * @private
         * @param {*} value The value to check.
         * @returns {boolean} Returns `true` if `value` is a native function,
         *  else `false`.
         */
        function baseIsNative(value) {
          if (!isObject(value) || isMasked(value)) {
            return false;
          }
          var pattern = isFunction(value) ? reIsNative : reIsHostCtor;
          return pattern.test(toSource(value));
        }

        /**
         * The base implementation of `_.isTypedArray` without Node.js optimizations.
         *
         * @private
         * @param {*} value The value to check.
         * @returns {boolean} Returns `true` if `value` is a typed array, else `false`.
         */
        function baseIsTypedArray(value) {
          return isObjectLike(value) &&
              isLength(value.length) && !!typedArrayTags[baseGetTag(value)];
        }

        /**
         * The base implementation of `_.keys` which doesn't treat sparse arrays as dense.
         *
         * @private
         * @param {Object} object The object to query.
         * @returns {Array} Returns the array of property names.
         */
        function baseKeys(object) {
          if (!isPrototype(object)) {
            return nativeKeys(object);
          }
          var result = [];
          for (var key in Object(object)) {
            if (hasOwnProperty.call(object, key) && key != 'constructor') {
              result.push(key);
            }
          }
          return result;
        }

        /**
         * A specialized version of `baseIsEqualDeep` for arrays with support for
         * partial deep comparisons.
         *
         * @private
         * @param {Array} array The array to compare.
         * @param {Array} other The other array to compare.
         * @param {number} bitmask The bitmask flags. See `baseIsEqual` for more details.
         * @param {Function} customizer The function to customize comparisons.
         * @param {Function} equalFunc The function to determine equivalents of values.
         * @param {Object} stack Tracks traversed `array` and `other` objects.
         * @returns {boolean} Returns `true` if the arrays are equivalent, else `false`.
         */
        function equalArrays(array, other, bitmask, customizer, equalFunc, stack) {
          var isPartial = bitmask & COMPARE_PARTIAL_FLAG,
              arrLength = array.length,
              othLength = other.length;

          if (arrLength != othLength && !(isPartial && othLength > arrLength)) {
            return false;
          }
          // Assume cyclic values are equal.
          var stacked = stack.get(array);
          if (stacked && stack.get(other)) {
            return stacked == other;
          }
          var index = -1,
              result = true,
              seen = (bitmask & COMPARE_UNORDERED_FLAG) ? new SetCache : undefined;

          stack.set(array, other);
          stack.set(other, array);

          // Ignore non-index properties.
          while (++index < arrLength) {
            var arrValue = array[index],
                othValue = other[index];

            if (customizer) {
              var compared = isPartial
                  ? customizer(othValue, arrValue, index, other, array, stack)
                  : customizer(arrValue, othValue, index, array, other, stack);
            }
            if (compared !== undefined) {
              if (compared) {
                continue;
              }
              result = false;
              break;
            }
            // Recursively compare arrays (susceptible to call stack limits).
            if (seen) {
              if (!arraySome(other, function(othValue, othIndex) {
                if (!cacheHas(seen, othIndex) &&
                    (arrValue === othValue || equalFunc(arrValue, othValue, bitmask, customizer, stack))) {
                  return seen.push(othIndex);
                }
              })) {
                result = false;
                break;
              }
            } else if (!(
                arrValue === othValue ||
                equalFunc(arrValue, othValue, bitmask, customizer, stack)
            )) {
              result = false;
              break;
            }
          }
          stack['delete'](array);
          stack['delete'](other);
          return result;
        }

        /**
         * A specialized version of `baseIsEqualDeep` for comparing objects of
         * the same `toStringTag`.
         *
         * **Note:** This function only supports comparing values with tags of
         * `Boolean`, `Date`, `Error`, `Number`, `RegExp`, or `String`.
         *
         * @private
         * @param {Object} object The object to compare.
         * @param {Object} other The other object to compare.
         * @param {string} tag The `toStringTag` of the objects to compare.
         * @param {number} bitmask The bitmask flags. See `baseIsEqual` for more details.
         * @param {Function} customizer The function to customize comparisons.
         * @param {Function} equalFunc The function to determine equivalents of values.
         * @param {Object} stack Tracks traversed `object` and `other` objects.
         * @returns {boolean} Returns `true` if the objects are equivalent, else `false`.
         */
        function equalByTag(object, other, tag, bitmask, customizer, equalFunc, stack) {
          switch (tag) {
            case dataViewTag:
              if ((object.byteLength != other.byteLength) ||
                  (object.byteOffset != other.byteOffset)) {
                return false;
              }
              object = object.buffer;
              other = other.buffer;

            case arrayBufferTag:
              if ((object.byteLength != other.byteLength) ||
                  !equalFunc(new Uint8Array(object), new Uint8Array(other))) {
                return false;
              }
              return true;

            case boolTag:
            case dateTag:
            case numberTag:
              // Coerce booleans to `1` or `0` and dates to milliseconds.
              // Invalid dates are coerced to `NaN`.
              return eq(+object, +other);

            case errorTag:
              return object.name == other.name && object.message == other.message;

            case regexpTag:
            case stringTag:
              // Coerce regexes to strings and treat strings, primitives and objects,
              // as equal. See http://www.ecma-international.org/ecma-262/7.0/#sec-regexp.prototype.tostring
              // for more details.
              return object == (other + '');

            case mapTag:
              var convert = mapToArray;

            case setTag:
              var isPartial = bitmask & COMPARE_PARTIAL_FLAG;
              convert || (convert = setToArray);

              if (object.size != other.size && !isPartial) {
                return false;
              }
              // Assume cyclic values are equal.
              var stacked = stack.get(object);
              if (stacked) {
                return stacked == other;
              }
              bitmask |= COMPARE_UNORDERED_FLAG;

              // Recursively compare objects (susceptible to call stack limits).
              stack.set(object, other);
              var result = equalArrays(convert(object), convert(other), bitmask, customizer, equalFunc, stack);
              stack['delete'](object);
              return result;

            case symbolTag:
              if (symbolValueOf) {
                return symbolValueOf.call(object) == symbolValueOf.call(other);
              }
          }
          return false;
        }

        /**
         * A specialized version of `baseIsEqualDeep` for objects with support for
         * partial deep comparisons.
         *
         * @private
         * @param {Object} object The object to compare.
         * @param {Object} other The other object to compare.
         * @param {number} bitmask The bitmask flags. See `baseIsEqual` for more details.
         * @param {Function} customizer The function to customize comparisons.
         * @param {Function} equalFunc The function to determine equivalents of values.
         * @param {Object} stack Tracks traversed `object` and `other` objects.
         * @returns {boolean} Returns `true` if the objects are equivalent, else `false`.
         */
        function equalObjects(object, other, bitmask, customizer, equalFunc, stack) {
          var isPartial = bitmask & COMPARE_PARTIAL_FLAG,
              objProps = getAllKeys(object),
              objLength = objProps.length,
              othProps = getAllKeys(other),
              othLength = othProps.length;

          if (objLength != othLength && !isPartial) {
            return false;
          }
          var index = objLength;
          while (index--) {
            var key = objProps[index];
            if (!(isPartial ? key in other : hasOwnProperty.call(other, key))) {
              return false;
            }
          }
          // Assume cyclic values are equal.
          var stacked = stack.get(object);
          if (stacked && stack.get(other)) {
            return stacked == other;
          }
          var result = true;
          stack.set(object, other);
          stack.set(other, object);

          var skipCtor = isPartial;
          while (++index < objLength) {
            key = objProps[index];
            var objValue = object[key],
                othValue = other[key];

            if (customizer) {
              var compared = isPartial
                  ? customizer(othValue, objValue, key, other, object, stack)
                  : customizer(objValue, othValue, key, object, other, stack);
            }
            // Recursively compare objects (susceptible to call stack limits).
            if (!(compared === undefined
                    ? (objValue === othValue || equalFunc(objValue, othValue, bitmask, customizer, stack))
                    : compared
            )) {
              result = false;
              break;
            }
            skipCtor || (skipCtor = key == 'constructor');
          }
          if (result && !skipCtor) {
            var objCtor = object.constructor,
                othCtor = other.constructor;

            // Non `Object` object instances with different constructors are not equal.
            if (objCtor != othCtor &&
                ('constructor' in object && 'constructor' in other) &&
                !(typeof objCtor == 'function' && objCtor instanceof objCtor &&
                    typeof othCtor == 'function' && othCtor instanceof othCtor)) {
              result = false;
            }
          }
          stack['delete'](object);
          stack['delete'](other);
          return result;
        }

        /**
         * Creates an array of own enumerable property names and symbols of `object`.
         *
         * @private
         * @param {Object} object The object to query.
         * @returns {Array} Returns the array of property names and symbols.
         */
        function getAllKeys(object) {
          return baseGetAllKeys(object, keys, getSymbols);
        }

        /**
         * Gets the data for `map`.
         *
         * @private
         * @param {Object} map The map to query.
         * @param {string} key The reference key.
         * @returns {*} Returns the map data.
         */
        function getMapData(map, key) {
          var data = map.__data__;
          return isKeyable(key)
              ? data[typeof key == 'string' ? 'string' : 'hash']
              : data.map;
        }

        /**
         * Gets the native function at `key` of `object`.
         *
         * @private
         * @param {Object} object The object to query.
         * @param {string} key The key of the method to get.
         * @returns {*} Returns the function if it's native, else `undefined`.
         */
        function getNative(object, key) {
          var value = getValue(object, key);
          return baseIsNative(value) ? value : undefined;
        }

        /**
         * A specialized version of `baseGetTag` which ignores `Symbol.toStringTag` values.
         *
         * @private
         * @param {*} value The value to query.
         * @returns {string} Returns the raw `toStringTag`.
         */
        function getRawTag(value) {
          var isOwn = hasOwnProperty.call(value, symToStringTag),
              tag = value[symToStringTag];

          try {
            value[symToStringTag] = undefined;
            var unmasked = true;
          } catch (e) {}

          var result = nativeObjectToString.call(value);
          if (unmasked) {
            if (isOwn) {
              value[symToStringTag] = tag;
            } else {
              delete value[symToStringTag];
            }
          }
          return result;
        }

        /**
         * Creates an array of the own enumerable symbols of `object`.
         *
         * @private
         * @param {Object} object The object to query.
         * @returns {Array} Returns the array of symbols.
         */
        var getSymbols = !nativeGetSymbols ? stubArray : function(object) {
          if (object == null) {
            return [];
          }
          object = Object(object);
          return arrayFilter(nativeGetSymbols(object), function(symbol) {
            return propertyIsEnumerable.call(object, symbol);
          });
        };

        /**
         * Gets the `toStringTag` of `value`.
         *
         * @private
         * @param {*} value The value to query.
         * @returns {string} Returns the `toStringTag`.
         */
        var getTag = baseGetTag;

// Fallback for data views, maps, sets, and weak maps in IE 11 and promises in Node.js < 6.
        if ((DataView && getTag(new DataView(new ArrayBuffer(1))) != dataViewTag) ||
            (Map && getTag(new Map) != mapTag) ||
            (Promise && getTag(Promise.resolve()) != promiseTag) ||
            (Set && getTag(new Set) != setTag) ||
            (WeakMap && getTag(new WeakMap) != weakMapTag)) {
          getTag = function(value) {
            var result = baseGetTag(value),
                Ctor = result == objectTag ? value.constructor : undefined,
                ctorString = Ctor ? toSource(Ctor) : '';

            if (ctorString) {
              switch (ctorString) {
                case dataViewCtorString: return dataViewTag;
                case mapCtorString: return mapTag;
                case promiseCtorString: return promiseTag;
                case setCtorString: return setTag;
                case weakMapCtorString: return weakMapTag;
              }
            }
            return result;
          };
        }

        /**
         * Checks if `value` is a valid array-like index.
         *
         * @private
         * @param {*} value The value to check.
         * @param {number} [length=MAX_SAFE_INTEGER] The upper bounds of a valid index.
         * @returns {boolean} Returns `true` if `value` is a valid index, else `false`.
         */
        function isIndex(value, length) {
          length = length == null ? MAX_SAFE_INTEGER : length;
          return !!length &&
              (typeof value == 'number' || reIsUint.test(value)) &&
              (value > -1 && value % 1 == 0 && value < length);
        }

        /**
         * Checks if `value` is suitable for use as unique object key.
         *
         * @private
         * @param {*} value The value to check.
         * @returns {boolean} Returns `true` if `value` is suitable, else `false`.
         */
        function isKeyable(value) {
          var type = typeof value;
          return (type == 'string' || type == 'number' || type == 'symbol' || type == 'boolean')
              ? (value !== '__proto__')
              : (value === null);
        }

        /**
         * Checks if `func` has its source masked.
         *
         * @private
         * @param {Function} func The function to check.
         * @returns {boolean} Returns `true` if `func` is masked, else `false`.
         */
        function isMasked(func) {
          return !!maskSrcKey && (maskSrcKey in func);
        }

        /**
         * Checks if `value` is likely a prototype object.
         *
         * @private
         * @param {*} value The value to check.
         * @returns {boolean} Returns `true` if `value` is a prototype, else `false`.
         */
        function isPrototype(value) {
          var Ctor = value && value.constructor,
              proto = (typeof Ctor == 'function' && Ctor.prototype) || objectProto;

          return value === proto;
        }

        /**
         * Converts `value` to a string using `Object.prototype.toString`.
         *
         * @private
         * @param {*} value The value to convert.
         * @returns {string} Returns the converted string.
         */
        function objectToString(value) {
          return nativeObjectToString.call(value);
        }

        /**
         * Converts `func` to its source code.
         *
         * @private
         * @param {Function} func The function to convert.
         * @returns {string} Returns the source code.
         */
        function toSource(func) {
          if (func != null) {
            try {
              return funcToString.call(func);
            } catch (e) {}
            try {
              return (func + '');
            } catch (e) {}
          }
          return '';
        }

        /**
         * Performs a
         * [`SameValueZero`](http://ecma-international.org/ecma-262/7.0/#sec-samevaluezero)
         * comparison between two values to determine if they are equivalent.
         *
         * @static
         * @memberOf _
         * @since 4.0.0
         * @category Lang
         * @param {*} value The value to compare.
         * @param {*} other The other value to compare.
         * @returns {boolean} Returns `true` if the values are equivalent, else `false`.
         * @example
         *
         * var object = { 'a': 1 };
         * var other = { 'a': 1 };
         *
         * _.eq(object, object);
         * // => true
         *
         * _.eq(object, other);
         * // => false
         *
         * _.eq('a', 'a');
         * // => true
         *
         * _.eq('a', Object('a'));
         * // => false
         *
         * _.eq(NaN, NaN);
         * // => true
         */
        function eq(value, other) {
          return value === other || (value !== value && other !== other);
        }

        /**
         * Checks if `value` is likely an `arguments` object.
         *
         * @static
         * @memberOf _
         * @since 0.1.0
         * @category Lang
         * @param {*} value The value to check.
         * @returns {boolean} Returns `true` if `value` is an `arguments` object,
         *  else `false`.
         * @example
         *
         * _.isArguments(function() { return arguments; }());
         * // => true
         *
         * _.isArguments([1, 2, 3]);
         * // => false
         */
        var isArguments = baseIsArguments(function() { return arguments; }()) ? baseIsArguments : function(value) {
          return isObjectLike(value) && hasOwnProperty.call(value, 'callee') &&
              !propertyIsEnumerable.call(value, 'callee');
        };

        /**
         * Checks if `value` is classified as an `Array` object.
         *
         * @static
         * @memberOf _
         * @since 0.1.0
         * @category Lang
         * @param {*} value The value to check.
         * @returns {boolean} Returns `true` if `value` is an array, else `false`.
         * @example
         *
         * _.isArray([1, 2, 3]);
         * // => true
         *
         * _.isArray(document.body.children);
         * // => false
         *
         * _.isArray('abc');
         * // => false
         *
         * _.isArray(_.noop);
         * // => false
         */
        var isArray = Array.isArray;

        /**
         * Checks if `value` is array-like. A value is considered array-like if it's
         * not a function and has a `value.length` that's an integer greater than or
         * equal to `0` and less than or equal to `Number.MAX_SAFE_INTEGER`.
         *
         * @static
         * @memberOf _
         * @since 4.0.0
         * @category Lang
         * @param {*} value The value to check.
         * @returns {boolean} Returns `true` if `value` is array-like, else `false`.
         * @example
         *
         * _.isArrayLike([1, 2, 3]);
         * // => true
         *
         * _.isArrayLike(document.body.children);
         * // => true
         *
         * _.isArrayLike('abc');
         * // => true
         *
         * _.isArrayLike(_.noop);
         * // => false
         */
        function isArrayLike(value) {
          return value != null && isLength(value.length) && !isFunction(value);
        }

        /**
         * Checks if `value` is a buffer.
         *
         * @static
         * @memberOf _
         * @since 4.3.0
         * @category Lang
         * @param {*} value The value to check.
         * @returns {boolean} Returns `true` if `value` is a buffer, else `false`.
         * @example
         *
         * _.isBuffer(new Buffer(2));
         * // => true
         *
         * _.isBuffer(new Uint8Array(2));
         * // => false
         */
        var isBuffer = nativeIsBuffer || stubFalse;

        /**
         * Performs a deep comparison between two values to determine if they are
         * equivalent.
         *
         * **Note:** This method supports comparing arrays, array buffers, booleans,
         * date objects, error objects, maps, numbers, `Object` objects, regexes,
         * sets, strings, symbols, and typed arrays. `Object` objects are compared
         * by their own, not inherited, enumerable properties. Functions and DOM
         * nodes are compared by strict equality, i.e. `===`.
         *
         * @static
         * @memberOf _
         * @since 0.1.0
         * @category Lang
         * @param {*} value The value to compare.
         * @param {*} other The other value to compare.
         * @returns {boolean} Returns `true` if the values are equivalent, else `false`.
         * @example
         *
         * var object = { 'a': 1 };
         * var other = { 'a': 1 };
         *
         * _.isEqual(object, other);
         * // => true
         *
         * object === other;
         * // => false
         */
        function isEqual(value, other) {
          return baseIsEqual(value, other);
        }

        /**
         * Checks if `value` is classified as a `Function` object.
         *
         * @static
         * @memberOf _
         * @since 0.1.0
         * @category Lang
         * @param {*} value The value to check.
         * @returns {boolean} Returns `true` if `value` is a function, else `false`.
         * @example
         *
         * _.isFunction(_);
         * // => true
         *
         * _.isFunction(/abc/);
         * // => false
         */
        function isFunction(value) {
          if (!isObject(value)) {
            return false;
          }
          // The use of `Object#toString` avoids issues with the `typeof` operator
          // in Safari 9 which returns 'object' for typed arrays and other constructors.
          var tag = baseGetTag(value);
          return tag == funcTag || tag == genTag || tag == asyncTag || tag == proxyTag;
        }

        /**
         * Checks if `value` is a valid array-like length.
         *
         * **Note:** This method is loosely based on
         * [`ToLength`](http://ecma-international.org/ecma-262/7.0/#sec-tolength).
         *
         * @static
         * @memberOf _
         * @since 4.0.0
         * @category Lang
         * @param {*} value The value to check.
         * @returns {boolean} Returns `true` if `value` is a valid length, else `false`.
         * @example
         *
         * _.isLength(3);
         * // => true
         *
         * _.isLength(Number.MIN_VALUE);
         * // => false
         *
         * _.isLength(Infinity);
         * // => false
         *
         * _.isLength('3');
         * // => false
         */
        function isLength(value) {
          return typeof value == 'number' &&
              value > -1 && value % 1 == 0 && value <= MAX_SAFE_INTEGER;
        }

        /**
         * Checks if `value` is the
         * [language type](http://www.ecma-international.org/ecma-262/7.0/#sec-ecmascript-language-types)
         * of `Object`. (e.g. arrays, functions, objects, regexes, `new Number(0)`, and `new String('')`)
         *
         * @static
         * @memberOf _
         * @since 0.1.0
         * @category Lang
         * @param {*} value The value to check.
         * @returns {boolean} Returns `true` if `value` is an object, else `false`.
         * @example
         *
         * _.isObject({});
         * // => true
         *
         * _.isObject([1, 2, 3]);
         * // => true
         *
         * _.isObject(_.noop);
         * // => true
         *
         * _.isObject(null);
         * // => false
         */
        function isObject(value) {
          var type = typeof value;
          return value != null && (type == 'object' || type == 'function');
        }

        /**
         * Checks if `value` is object-like. A value is object-like if it's not `null`
         * and has a `typeof` result of "object".
         *
         * @static
         * @memberOf _
         * @since 4.0.0
         * @category Lang
         * @param {*} value The value to check.
         * @returns {boolean} Returns `true` if `value` is object-like, else `false`.
         * @example
         *
         * _.isObjectLike({});
         * // => true
         *
         * _.isObjectLike([1, 2, 3]);
         * // => true
         *
         * _.isObjectLike(_.noop);
         * // => false
         *
         * _.isObjectLike(null);
         * // => false
         */
        function isObjectLike(value) {
          return value != null && typeof value == 'object';
        }

        /**
         * Checks if `value` is classified as a typed array.
         *
         * @static
         * @memberOf _
         * @since 3.0.0
         * @category Lang
         * @param {*} value The value to check.
         * @returns {boolean} Returns `true` if `value` is a typed array, else `false`.
         * @example
         *
         * _.isTypedArray(new Uint8Array);
         * // => true
         *
         * _.isTypedArray([]);
         * // => false
         */
        var isTypedArray = nodeIsTypedArray ? baseUnary(nodeIsTypedArray) : baseIsTypedArray;

        /**
         * Creates an array of the own enumerable property names of `object`.
         *
         * **Note:** Non-object values are coerced to objects. See the
         * [ES spec](http://ecma-international.org/ecma-262/7.0/#sec-object.keys)
         * for more details.
         *
         * @static
         * @since 0.1.0
         * @memberOf _
         * @category Object
         * @param {Object} object The object to query.
         * @returns {Array} Returns the array of property names.
         * @example
         *
         * function Foo() {
         *   this.a = 1;
         *   this.b = 2;
         * }
         *
         * Foo.prototype.c = 3;
         *
         * _.keys(new Foo);
         * // => ['a', 'b'] (iteration order is not guaranteed)
         *
         * _.keys('hi');
         * // => ['0', '1']
         */
        function keys(object) {
          return isArrayLike(object) ? arrayLikeKeys(object) : baseKeys(object);
        }

        /**
         * This method returns a new empty array.
         *
         * @static
         * @memberOf _
         * @since 4.13.0
         * @category Util
         * @returns {Array} Returns the new empty array.
         * @example
         *
         * var arrays = _.times(2, _.stubArray);
         *
         * console.log(arrays);
         * // => [[], []]
         *
         * console.log(arrays[0] === arrays[1]);
         * // => false
         */
        function stubArray() {
          return [];
        }

        /**
         * This method returns `false`.
         *
         * @static
         * @memberOf _
         * @since 4.13.0
         * @category Util
         * @returns {boolean} Returns `false`.
         * @example
         *
         * _.times(2, _.stubFalse);
         * // => [false, false]
         */
        function stubFalse() {
          return false;
        }

        module.exports = isEqual;
      });

// all diacritics
      var diacritics = {
        a: ["a", "à", "á", "â", "ã", "ä", "å", "æ", "ā", "ă", "ą", "ǎ", "ǟ", "ǡ", "ǻ", "ȁ", "ȃ", "ȧ", "ɐ", "ɑ", "ɒ", "ͣ", "а", "ӑ", "ӓ", "ᵃ", "ᵄ", "ᶏ", "ḁ", "ẚ", "ạ", "ả", "ấ", "ầ", "ẩ", "ẫ", "ậ", "ắ", "ằ", "ẳ", "ẵ", "ặ", "ₐ", "ⱥ", "ａ"],
        b: ["b", "ƀ", "ƃ", "ɓ", "ᖯ", "ᵇ", "ᵬ", "ᶀ", "ḃ", "ḅ", "ḇ", "ｂ"],
        c: ["c", "ç", "ć", "ĉ", "ċ", "č", "ƈ", "ȼ", "ɕ", "ͨ", "ᴄ", "ᶜ", "ḉ", "ↄ", "ｃ"],
        d: ["d", "ď", "đ", "Ƌ", "ƌ", "ȡ", "ɖ", "ɗ", "ͩ", "ᵈ", "ᵭ", "ᶁ", "ᶑ", "ḋ", "ḍ", "ḏ", "ḑ", "ḓ", "ｄ"],
        e: ["e", "è", "é", "ê", "ë", "ē", "ĕ", "ė", "ę", "ě", "ǝ", "ȅ", "ȇ", "ȩ", "ɇ", "ɘ", "ͤ", "ᵉ", "ᶒ", "ḕ", "ḗ", "ḙ", "ḛ", "ḝ", "ẹ", "ẻ", "ẽ", "ế", "ề", "ể", "ễ", "ệ", "ₑ", "ｅ"],
        f: ["f", "ƒ", "ᵮ", "ᶂ", "ᶠ", "ḟ", "ｆ"],
        g: ["g", "ĝ", "ğ", "ġ", "ģ", "ǥ", "ǧ", "ǵ", "ɠ", "ɡ", "ᵍ", "ᵷ", "ᵹ", "ᶃ", "ᶢ", "ḡ", "ｇ"],
        h: ["h", "ĥ", "ħ", "ƕ", "ȟ", "ɥ", "ɦ", "ʮ", "ʯ", "ʰ", "ʱ", "ͪ", "Һ", "һ", "ᑋ", "ᶣ", "ḣ", "ḥ", "ḧ", "ḩ", "ḫ", "ⱨ", "ｈ"],
        i: ["i", "ì", "í", "î", "ï", "ĩ", "ī", "ĭ", "į", "ǐ", "ȉ", "ȋ", "ɨ", "ͥ", "ᴉ", "ᵎ", "ᵢ", "ᶖ", "ᶤ", "ḭ", "ḯ", "ỉ", "ị", "ｉ"],
        j: ["j", "ĵ", "ǰ", "ɉ", "ʝ", "ʲ", "ᶡ", "ᶨ", "ｊ"],
        k: ["k", "ķ", "ƙ", "ǩ", "ʞ", "ᵏ", "ᶄ", "ḱ", "ḳ", "ḵ", "ⱪ", "ｋ"],
        l: ["l", "ĺ", "ļ", "ľ", "ŀ", "ł", "ƚ", "ȴ", "ɫ", "ɬ", "ɭ", "ˡ", "ᶅ", "ᶩ", "ᶪ", "ḷ", "ḹ", "ḻ", "ḽ", "ℓ", "ⱡ"],
        m: ["m", "ɯ", "ɰ", "ɱ", "ͫ", "ᴟ", "ᵐ", "ᵚ", "ᵯ", "ᶆ", "ᶬ", "ᶭ", "ḿ", "ṁ", "ṃ", "㎡", "㎥", "ｍ"],
        n: ["n", "ñ", "ń", "ņ", "ň", "ŉ", "ƞ", "ǹ", "ȵ", "ɲ", "ɳ", "ᵰ", "ᶇ", "ᶮ", "ᶯ", "ṅ", "ṇ", "ṉ", "ṋ", "ⁿ", "ｎ"],
        o: ["o", "ò", "ó", "ô", "õ", "ö", "ø", "ō", "ŏ", "ő", "ơ", "ǒ", "ǫ", "ǭ", "ǿ", "ȍ", "ȏ", "ȫ", "ȭ", "ȯ", "ȱ", "ɵ", "ͦ", "о", "ӧ", "ө", "ᴏ", "ᴑ", "ᴓ", "ᴼ", "ᵒ", "ᶱ", "ṍ", "ṏ", "ṑ", "ṓ", "ọ", "ỏ", "ố", "ồ", "ổ", "ỗ", "ộ", "ớ", "ờ", "ở", "ỡ", "ợ", "ₒ", "ｏ", "𐐬"],
        p: ["p", "ᵖ", "ᵱ", "ᵽ", "ᶈ", "ṕ", "ṗ", "ｐ"],
        q: ["q", "ɋ", "ʠ", "ᛩ", "ｑ"],
        r: ["r", "ŕ", "ŗ", "ř", "ȑ", "ȓ", "ɍ", "ɹ", "ɻ", "ʳ", "ʴ", "ʵ", "ͬ", "ᵣ", "ᵲ", "ᶉ", "ṙ", "ṛ", "ṝ", "ṟ"],
        s: ["s", "ś", "ŝ", "ş", "š", "ș", "ʂ", "ᔆ", "ᶊ", "ṡ", "ṣ", "ṥ", "ṧ", "ṩ", "ｓ"],
        t: ["t", "ţ", "ť", "ŧ", "ƫ", "ƭ", "ț", "ʇ", "ͭ", "ᵀ", "ᵗ", "ᵵ", "ᶵ", "ṫ", "ṭ", "ṯ", "ṱ", "ẗ", "ｔ"],
        u: ["u", "ù", "ú", "û", "ü", "ũ", "ū", "ŭ", "ů", "ű", "ų", "ư", "ǔ", "ǖ", "ǘ", "ǚ", "ǜ", "ȕ", "ȗ", "ͧ", "ߎ", "ᵘ", "ᵤ", "ṳ", "ṵ", "ṷ", "ṹ", "ṻ", "ụ", "ủ", "ứ", "ừ", "ử", "ữ", "ự", "ｕ"],
        v: ["v", "ʋ", "ͮ", "ᵛ", "ᵥ", "ᶹ", "ṽ", "ṿ", "ⱱ", "ｖ", "ⱴ"],
        w: ["w", "ŵ", "ʷ", "ᵂ", "ẁ", "ẃ", "ẅ", "ẇ", "ẉ", "ẘ", "ⱳ", "ｗ"],
        x: ["x", "̽", "͓", "ᶍ", "ͯ", "ẋ", "ẍ", "ₓ", "ｘ"],
        y: ["y", "ý", "ÿ", "ŷ", "ȳ", "ɏ", "ʸ", "ẏ", "ỳ", "ỵ", "ỷ", "ỹ", "ｙ"],
        z: ["z", "ź", "ż", "ž", "ƶ", "ȥ", "ɀ", "ʐ", "ʑ", "ᙆ", "ᙇ", "ᶻ", "ᶼ", "ᶽ", "ẑ", "ẓ", "ẕ", "ⱬ", "ｚ"]
      }; // Precompiled Object with { key = Diacritic, value = real-Character }

      var compiledDiactitics = function () {
        var x = {};

        for (var key in diacritics) {
          var ok = diacritics[key];

          for (var rval in ok) {
            var val = ok[rval]; // Do not replace the char with itself

            if (val !== key) {
              x[val] = key;
            }
          }
        }

        return x;
      }(); // Regex for detecting non-ASCII-Characters in String


      var regexNonASCII = /[^a-z0-9\s,.-]/;
      /*
 * Main function of the module which removes all diacritics from the received text
 */

      var diacriticless = function diacriticless(text) {
        // When there are only ascii-Characters in the string, skip processing and return text right away
        if (text.search(regexNonASCII) === -1) {
          return text;
        }

        var result = "";
        var len = text.length;

        for (var i = 0; i < len; i++) {
          var searchChar = text.charAt(i); // If applicable replace the diacritic character with the real one or use the original value

          result += searchChar in compiledDiactitics ? compiledDiactitics[searchChar] : searchChar;
        }

        return result;
      };

      var escapeRegExp = function escapeRegExp(str) {
        return str.replace(/[\\^$*+?.()|[\]{}]/g, '\\$&');
      };

      var defaultType = {
        format: function format(x) {
          return x;
        },
        filterPredicate: function filterPredicate(rowval, filter) {
          var skipDiacritics = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;
          var fromDropdown = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : false;

          // take care of nulls
          if (typeof rowval === 'undefined' || rowval === null) {
            return false;
          } // row value


          var rowValue = skipDiacritics ? String(rowval).toLowerCase() : diacriticless(escapeRegExp(String(rowval)).toLowerCase()); // search term

          var searchTerm = skipDiacritics ? filter.toLowerCase() : diacriticless(escapeRegExp(filter).toLowerCase()); // comparison

          return fromDropdown ? rowValue === searchTerm : rowValue.indexOf(searchTerm) > -1;
        },
        compare: function compare(x, y) {
          function cook(d) {
            if (typeof d === 'undefined' || d === null) return '';
            return diacriticless(String(d).toLowerCase());
          }

          x = cook(x);
          y = cook(y);
          if (x < y) return -1;
          if (x > y) return 1;
          return 0;
        }
      };

//
      var script = {
        name: 'VgtPaginationPageInfo',
        props: {
          currentPage: {
            "default": 1
          },
          lastPage: {
            "default": 1
          },
          totalRecords: {
            "default": 0
          },
          ofText: {
            "default": 'of',
            type: String
          },
          pageText: {
            "default": 'page',
            type: String
          },
          currentPerPage: {},
          mode: {
            "default": PAGINATION_MODES.Records
          },
          infoFn: {
            "default": null
          }
        },
        data: function data() {
          return {
            id: this.getId()
          };
        },
        computed: {
          pageInfo: function pageInfo() {
            return "".concat(this.ofText, " ").concat(this.lastPage);
          },
          firstRecordOnPage: function firstRecordOnPage() {
            return (this.currentPage - 1) * this.currentPerPage + 1;
          },
          lastRecordOnPage: function lastRecordOnPage() {
            // if the setting is set to 'all'
            if (this.currentPerPage === -1) {
              return this.totalRecords;
            }

            return Math.min(this.totalRecords, this.currentPage * this.currentPerPage);
          },
          recordInfo: function recordInfo() {
            var first = this.firstRecordOnPage;
            var last = this.lastRecordOnPage;

            if (last === 0) {
              first = 0;
            }

            return "".concat(first, " - ").concat(last, " ").concat(this.ofText, " ").concat(this.totalRecords);
          },
          infoParams: function infoParams() {
            var first = this.firstRecordOnPage;
            var last = this.lastRecordOnPage;

            if (last === 0) {
              first = 0;
            }

            return {
              firstRecordOnPage: first,
              lastRecordOnPage: last,
              totalRecords: this.totalRecords,
              currentPage: this.currentPage,
              totalPage: this.lastPage
            };
          }
        },
        methods: {
          getId: function getId() {
            return "vgt-page-input-".concat(Math.floor(Math.random() * Date.now()));
          },
          changePage: function changePage(event) {
            var value = parseInt(event.target.value, 10); //! invalid number

            if (Number.isNaN(value) || value > this.lastPage || value < 1) {
              event.target.value = this.currentPage;
              return false;
            } //* valid number


            event.target.value = value;
            this.$emit('page-changed', value);
          }
        },
        mounted: function mounted() {},
        components: {}
      };

      function normalizeComponent(template, style, script, scopeId, isFunctionalTemplate, moduleIdentifier /* server only */, shadowMode, createInjector, createInjectorSSR, createInjectorShadow) {
        if (typeof shadowMode !== 'boolean') {
          createInjectorSSR = createInjector;
          createInjector = shadowMode;
          shadowMode = false;
        }
        // Vue.extend constructor export interop.
        const options = typeof script === 'function' ? script.options : script;
        // render functions
        if (template && template.render) {
          options.render = template.render;
          options.staticRenderFns = template.staticRenderFns;
          options._compiled = true;
          // functional template
          if (isFunctionalTemplate) {
            options.functional = true;
          }
        }
        // scopedId
        if (scopeId) {
          options._scopeId = scopeId;
        }
        let hook;
        if (moduleIdentifier) {
          // server build
          hook = function (context) {
            // 2.3 injection
            context =
                context || // cached call
                (this.$vnode && this.$vnode.ssrContext) || // stateful
                (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext); // functional
            // 2.2 with runInNewContext: true
            if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
              context = __VUE_SSR_CONTEXT__;
            }
            // inject component styles
            if (style) {
              style.call(this, createInjectorSSR(context));
            }
            // register component module identifier for async chunk inference
            if (context && context._registeredComponents) {
              context._registeredComponents.add(moduleIdentifier);
            }
          };
          // used by ssr in case component is cached and beforeCreate
          // never gets called
          options._ssrRegister = hook;
        }
        else if (style) {
          hook = shadowMode
              ? function (context) {
                style.call(this, createInjectorShadow(context, this.$root.$options.shadowRoot));
              }
              : function (context) {
                style.call(this, createInjector(context));
              };
        }
        if (hook) {
          if (options.functional) {
            // register for functional component in vue file
            const originalRender = options.render;
            options.render = function renderWithStyleInjection(h, context) {
              hook.call(context);
              return originalRender(h, context);
            };
          }
          else {
            // inject component registration as beforeCreate hook
            const existing = options.beforeCreate;
            options.beforeCreate = existing ? [].concat(existing, hook) : [hook];
          }
        }
        return script;
      }

      /* script */
      var __vue_script__ = script;
      /* template */

      var __vue_render__ = function __vue_render__() {
        var _vm = this;

        var _h = _vm.$createElement;

        var _c = _vm._self._c || _h;

        return _c('div', {
          staticClass: "footer__navigation__page-info"
        }, [_vm.infoFn ? _c('div', [_vm._v("\n    " + _vm._s(_vm.infoFn(_vm.infoParams)) + "\n  ")]) : _vm.mode === 'pages' ? _c('form', {
          on: {
            "submit": function submit($event) {
              $event.preventDefault();
            }
          }
        }, [_c('label', {
          staticClass: "page-info__label",
          attrs: {
            "for": _vm.id
          }
        }, [_c('span', [_vm._v(_vm._s(_vm.pageText))]), _vm._v(" "), _c('input', {
          staticClass: "footer__navigation__page-info__current-entry",
          attrs: {
            "id": _vm.id,
            "aria-describedby": "change-page-hint",
            "aria-controls": "vgb-table",
            "type": "text"
          },
          domProps: {
            "value": _vm.currentPage
          },
          on: {
            "keyup": function keyup($event) {
              if (!$event.type.indexOf('key') && _vm._k($event.keyCode, "enter", 13, $event.key, "Enter")) {
                return null;
              }

              $event.stopPropagation();
              return _vm.changePage($event);
            }
          }
        }), _vm._v(" "), _c('span', [_vm._v(_vm._s(_vm.pageInfo))])]), _vm._v(" "), _c('span', {
          staticStyle: {
            "display": "none"
          },
          attrs: {
            "id": "change-page-hint"
          }
        }, [_vm._v("\n      Type a page number and press Enter to change the page.\n    ")])]) : _c('div', [_vm._v("\n    " + _vm._s(_vm.recordInfo) + "\n  ")])]);
      };

      var __vue_staticRenderFns__ = [];
      /* style */

      var __vue_inject_styles__ = undefined;
      /* scoped */

      var __vue_scope_id__ = "data-v-347cbcfa";
      /* module identifier */

      var __vue_module_identifier__ = undefined;
      /* functional template */

      var __vue_is_functional_template__ = false;
      /* style inject */

      /* style inject SSR */

      /* style inject shadow dom */

      var __vue_component__ = /*#__PURE__*/normalizeComponent({
        render: __vue_render__,
        staticRenderFns: __vue_staticRenderFns__
      }, __vue_inject_styles__, __vue_script__, __vue_scope_id__, __vue_is_functional_template__, __vue_module_identifier__, false, undefined, undefined, undefined);

//
      var script$1 = {
        name: 'VgtPagination',
        props: {
          styleClass: {
            "default": 'table table-bordered'
          },
          total: {
            "default": null
          },
          perPage: {},
          rtl: {
            "default": false
          },
          perPageDropdownEnabled: {
            "default": true
          },
          customRowsPerPageDropdown: {
            "default": function _default() {
              return [];
            }
          },
          paginateDropdownAllowAll: {
            "default": true
          },
          mode: {
            "default": PAGINATION_MODES.Records
          },
          jumpFirstOrLast: {
            "default": false
          },
          // text options
          firstText: {
            "default": "First"
          },
          lastText: {
            "default": "Last"
          },
          nextText: {
            "default": 'Next'
          },
          prevText: {
            "default": 'Prev'
          },
          rowsPerPageText: {
            "default": 'Rows per page:'
          },
          ofText: {
            "default": 'of'
          },
          pageText: {
            "default": 'page'
          },
          allText: {
            "default": 'All'
          },
          infoFn: {
            "default": null
          }
        },
        data: function data() {
          return {
            id: this.getId(),
            currentPage: 1,
            prevPage: 0,
            currentPerPage: 10,
            rowsPerPageOptions: []
          };
        },
        watch: {
          perPage: {
            handler: function handler(newValue, oldValue) {
              this.handlePerPage();
              this.perPageChanged(oldValue);
            },
            immediate: true
          },
          customRowsPerPageDropdown: function customRowsPerPageDropdown() {
            this.handlePerPage();
          },
          total: {
            handler: function handler(newValue, oldValue) {
              if (this.rowsPerPageOptions.indexOf(this.currentPerPage) === -1) {
                this.currentPerPage = newValue;
              }
            }
          }
        },
        computed: {
          // Number of pages
          pagesCount: function pagesCount() {
            // if the setting is set to 'all'
            if (this.currentPerPage === -1) {
              return 1;
            }

            var quotient = Math.floor(this.total / this.currentPerPage);
            var remainder = this.total % this.currentPerPage;
            return remainder === 0 ? quotient : quotient + 1;
          },
          // Can go to first page
          firstIsPossible: function firstIsPossible() {
            return this.currentPage > 1;
          },
          // Can go to last page
          lastIsPossible: function lastIsPossible() {
            return this.currentPage < Math.ceil(this.total / this.currentPerPage);
          },
          // Can go to next page
          nextIsPossible: function nextIsPossible() {
            return this.currentPage < this.pagesCount;
          },
          // Can go to previous page
          prevIsPossible: function prevIsPossible() {
            return this.currentPage > 1;
          }
        },
        methods: {
          getId: function getId() {
            return "vgt-select-rpp-".concat(Math.floor(Math.random() * Date.now()));
          },
          // Change current page
          changePage: function changePage(pageNumber) {
            var emit = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;

            if (pageNumber > 0 && this.total > this.currentPerPage * (pageNumber - 1)) {
              this.prevPage = this.currentPage;
              this.currentPage = pageNumber;
              this.pageChanged(emit);
            }
          },
          // Go to first page
          firstPage: function firstPage() {
            if (this.firstIsPossible) {
              this.currentPage = 1;
              this.prevPage = 0;
              this.pageChanged();
            }
          },
          // Go to last page
          lastPage: function lastPage() {
            if (this.lastIsPossible) {
              this.currentPage = this.pagesCount;
              this.prev = this.currentPage - 1;
              this.pageChanged();
            }
          },
          // Go to next page
          nextPage: function nextPage() {
            if (this.nextIsPossible) {
              this.prevPage = this.currentPage;
              ++this.currentPage;
              this.pageChanged();
            }
          },
          // Go to previous page
          previousPage: function previousPage() {
            if (this.prevIsPossible) {
              this.prevPage = this.currentPage;
              --this.currentPage;
              this.pageChanged();
            }
          },
          // Indicate page changing
          pageChanged: function pageChanged() {
            var emit = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : true;
            var payload = {
              currentPage: this.currentPage,
              prevPage: this.prevPage
            };
            if (!emit) payload.noEmit = true;
            this.$emit('page-changed', payload);
          },
          // Indicate per page changing
          perPageChanged: function perPageChanged(oldValue) {
            // go back to first page
            if (oldValue) {
              //* only emit if this isn't first initialization
              this.$emit('per-page-changed', {
                currentPerPage: this.currentPerPage
              });
            }

            this.changePage(1, false);
          },
          // Handle per page changing
          handlePerPage: function handlePerPage() {
            //* if there's a custom dropdown then we use that
            if (this.customRowsPerPageDropdown !== null && Array.isArray(this.customRowsPerPageDropdown) && this.customRowsPerPageDropdown.length !== 0) {
              this.rowsPerPageOptions = JSON.parse(JSON.stringify(this.customRowsPerPageDropdown));
            } else {
              //* otherwise we use the default rows per page dropdown
              this.rowsPerPageOptions = JSON.parse(JSON.stringify(DEFAULT_ROWS_PER_PAGE_DROPDOWN));
            }

            if (this.perPage) {
              this.currentPerPage = this.perPage; // if perPage doesn't already exist, we add it

              var found = false;

              for (var i = 0; i < this.rowsPerPageOptions.length; i++) {
                if (this.rowsPerPageOptions[i] === this.perPage) {
                  found = true;
                }
              }

              if (!found && this.perPage !== -1) {
                this.rowsPerPageOptions.unshift(this.perPage);
              }
            } else {
              // reset to default
              this.currentPerPage = 10;
            }
          }
        },
        mounted: function mounted() {},
        components: {
          'pagination-page-info': __vue_component__
        }
      };

      /* script */
      var __vue_script__$1 = script$1;
      /* template */

      var __vue_render__$1 = function __vue_render__() {
        var _vm = this;

        var _h = _vm.$createElement;

        var _c = _vm._self._c || _h;

        return _c('div', {
          staticClass: "vgt-wrap__footer vgt-clearfix"
        }, [_vm.perPageDropdownEnabled ? _c('div', {
          staticClass: "footer__row-count vgt-pull-left"
        }, [_c('form', [_c('label', {
          staticClass: "footer__row-count__label",
          attrs: {
            "for": _vm.id
          }
        }, [_vm._v(_vm._s(_vm.rowsPerPageText) + ":")]), _vm._v(" "), _c('select', {
          directives: [{
            name: "model",
            rawName: "v-model",
            value: _vm.currentPerPage,
            expression: "currentPerPage"
          }],
          staticClass: "footer__row-count__select",
          attrs: {
            "id": _vm.id,
            "autocomplete": "off",
            "name": "perPageSelect",
            "aria-controls": "vgt-table"
          },
          on: {
            "change": [function ($event) {

              var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {

                return o.selected;
              }).map(function (o) {
                var val = "_value" in o ? o._value : o.value;

                return val;
              });

              _vm.currentPerPage = $event.target.multiple ? $$selectedVal : $$selectedVal[0];
            }, _vm.perPageChanged]
          }
        }, [_vm._l(_vm.rowsPerPageOptions, function (option, idx) {
          return _c('option', {
            key: idx,
            domProps: {
              "value": option
            }
          }, [_vm._v("\n          " + _vm._s(option) + "\n        ")]);
        }), _vm._v(" "), _vm.paginateDropdownAllowAll ? _c('option', {
          domProps: {
            "value": -1
          }
        }, [_vm._v(_vm._s(_vm.allText))]) : _vm._e()], 2)])]) : _vm._e(), _vm._v(" "), _c('div', {
          staticClass: "footer__navigation vgt-pull-right"
        }, [_c('pagination-page-info', {
          attrs: {
            "total-records": _vm.total,
            "last-page": _vm.pagesCount,
            "current-page": _vm.currentPage,
            "current-per-page": _vm.currentPerPage,
            "of-text": _vm.ofText,
            "page-text": _vm.pageText,
            "info-fn": _vm.infoFn,
            "mode": _vm.mode
          },
          on: {
            "page-changed": _vm.changePage
          }
        }), _vm._v(" "), _vm.jumpFirstOrLast ? _c('button', {
          staticClass: "footer__navigation__page-btn",
          "class": {
            disabled: !_vm.firstIsPossible
          },
          attrs: {
            "type": "button",
            "aria-controls": "vgt-table"
          },
          on: {
            "click": function click($event) {
              $event.preventDefault();
              $event.stopPropagation();
              return _vm.firstPage($event);
            }
          }
        }, [_c('span', {
          staticClass: "chevron",
          "class": {
            left: !_vm.rtl,
            right: _vm.rtl
          },
          attrs: {
            "aria-hidden": "true"
          }
        }), _vm._v(" "), _c('span', [_vm._v(_vm._s(_vm.firstText))])]) : _vm._e(), _vm._v(" "), _c('button', {
          staticClass: "footer__navigation__page-btn",
          "class": {
            disabled: !_vm.prevIsPossible
          },
          attrs: {
            "type": "button",
            "aria-controls": "vgt-table"
          },
          on: {
            "click": function click($event) {
              $event.preventDefault();
              $event.stopPropagation();
              return _vm.previousPage($event);
            }
          }
        }, [_c('span', {
          staticClass: "chevron",
          "class": {
            'left': !_vm.rtl,
            'right': _vm.rtl
          },
          attrs: {
            "aria-hidden": "true"
          }
        }), _vm._v(" "), _c('span', [_vm._v(_vm._s(_vm.prevText))])]), _vm._v(" "), _c('button', {
          staticClass: "footer__navigation__page-btn",
          "class": {
            disabled: !_vm.nextIsPossible
          },
          attrs: {
            "type": "button",
            "aria-controls": "vgt-table"
          },
          on: {
            "click": function click($event) {
              $event.preventDefault();
              $event.stopPropagation();
              return _vm.nextPage($event);
            }
          }
        }, [_c('span', [_vm._v(_vm._s(_vm.nextText))]), _vm._v(" "), _c('span', {
          staticClass: "chevron",
          "class": {
            'right': !_vm.rtl,
            'left': _vm.rtl
          },
          attrs: {
            "aria-hidden": "true"
          }
        })]), _vm._v(" "), _vm.jumpFirstOrLast ? _c('button', {
          staticClass: "footer__navigation__page-btn",
          "class": {
            disabled: !_vm.lastIsPossible
          },
          attrs: {
            "type": "button",
            "aria-controls": "vgt-table"
          },
          on: {
            "click": function click($event) {
              $event.preventDefault();
              $event.stopPropagation();
              return _vm.lastPage($event);
            }
          }
        }, [_c('span', [_vm._v(_vm._s(_vm.lastText))]), _vm._v(" "), _c('span', {
          staticClass: "chevron",
          "class": {
            right: !_vm.rtl,
            left: _vm.rtl
          },
          attrs: {
            "aria-hidden": "true"
          }
        })]) : _vm._e()], 1)]);
      };

      var __vue_staticRenderFns__$1 = [];
      /* style */

      var __vue_inject_styles__$1 = undefined;
      /* scoped */

      var __vue_scope_id__$1 = undefined;
      /* module identifier */

      var __vue_module_identifier__$1 = undefined;
      /* functional template */

      var __vue_is_functional_template__$1 = false;
      /* style inject */

      /* style inject SSR */

      /* style inject shadow dom */

      var __vue_component__$1 = /*#__PURE__*/normalizeComponent({
        render: __vue_render__$1,
        staticRenderFns: __vue_staticRenderFns__$1
      }, __vue_inject_styles__$1, __vue_script__$1, __vue_scope_id__$1, __vue_is_functional_template__$1, __vue_module_identifier__$1, false, undefined, undefined, undefined);

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
      var script$2 = {
        name: 'VgtGlobalSearch',
        props: ['value', 'searchEnabled', 'globalSearchPlaceholder'],
        data: function data() {
          return {
            globalSearchTerm: null,
            id: this.getId()
          };
        },
        computed: {
          showControlBar: function showControlBar() {
            if (this.searchEnabled) return true;
            if (this.$slots && this.$slots['internal-table-actions']) return true;
            return false;
          }
        },
        methods: {
          updateValue: function updateValue(value) {
            this.$emit('input', value);
            this.$emit('on-keyup', value);
          },
          entered: function entered(value) {
            this.$emit('on-enter', value);
          },
          getId: function getId() {
            return "vgt-search-".concat(Math.floor(Math.random() * Date.now()));
          }
        }
      };

      /* script */
      var __vue_script__$2 = script$2;
      /* template */

      var __vue_render__$2 = function __vue_render__() {
        var _vm = this;

        var _h = _vm.$createElement;

        var _c = _vm._self._c || _h;

        return _vm.showControlBar ? _c('div', {
          staticClass: "vgt-global-search vgt-clearfix"
        }, [_c('div', {
          staticClass: "vgt-global-search__input vgt-pull-left"
        }, [_vm.searchEnabled ? _c('form', {
          attrs: {
            "role": "search"
          },
          on: {
            "submit": function submit($event) {
              $event.preventDefault();
            }
          }
        }, [_c('label', {
          attrs: {
            "for": _vm.id
          }
        }, [_vm._m(0), _vm._v(" "), _c('span', {
          staticClass: "sr-only"
        }, [_vm._v("Search")])]), _vm._v(" "), _c('input', {
          staticClass: "vgt-input vgt-pull-left",
          attrs: {
            "id": _vm.id,
            "type": "text",
            "placeholder": _vm.globalSearchPlaceholder
          },
          domProps: {
            "value": _vm.value
          },
          on: {
            "input": function input($event) {
              return _vm.updateValue($event.target.value);
            },
            "keyup": function keyup($event) {
              if (!$event.type.indexOf('key') && _vm._k($event.keyCode, "enter", 13, $event.key, "Enter")) {
                return null;
              }

              return _vm.entered($event.target.value);
            }
          }
        })]) : _vm._e()]), _vm._v(" "), _c('div', {
          staticClass: "vgt-global-search__actions vgt-pull-right"
        }, [_vm._t("internal-table-actions")], 2)]) : _vm._e();
      };

      var __vue_staticRenderFns__$2 = [function () {
        var _vm = this;

        var _h = _vm.$createElement;

        var _c = _vm._self._c || _h;

        return _c('span', {
          staticClass: "input__icon",
          attrs: {
            "aria-hidden": "true"
          }
        }, [_c('div', {
          staticClass: "magnifying-glass"
        })]);
      }];
      /* style */

      var __vue_inject_styles__$2 = undefined;
      /* scoped */

      var __vue_scope_id__$2 = undefined;
      /* module identifier */

      var __vue_module_identifier__$2 = undefined;
      /* functional template */

      var __vue_is_functional_template__$2 = false;
      /* style inject */

      /* style inject SSR */

      /* style inject shadow dom */

      var __vue_component__$2 = /*#__PURE__*/normalizeComponent({
        render: __vue_render__$2,
        staticRenderFns: __vue_staticRenderFns__$2
      }, __vue_inject_styles__$2, __vue_script__$2, __vue_scope_id__$2, __vue_is_functional_template__$2, __vue_module_identifier__$2, false, undefined, undefined, undefined);

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
      var script$3 = {
        name: 'VgtFilterRow',
        props: ['lineNumbers', 'columns', 'typedColumns', 'globalSearchEnabled', 'selectable', 'mode'],
        watch: {
          columns: {
            handler: function handler(newValue, oldValue) {
              this.populateInitialFilters();
            },
            deep: true,
            immediate: true
          }
        },
        data: function data() {
          return {
            columnFilters: {},
            timer: null
          };
        },
        computed: {
          // to create a filter row, we need to
          // make sure that there is atleast 1 column
          // that requires filtering
          hasFilterRow: function hasFilterRow() {
            // if (this.mode === 'remote' || !this.globalSearchEnabled) {
            for (var i = 0; i < this.columns.length; i++) {
              var col = this.columns[i];

              if (col.filterOptions && col.filterOptions.enabled) {
                return true;
              }
            } // }


            return false;
          }
        },
        methods: {
          fieldKey: function fieldKey(field) {
            if (typeof field === 'function' && field.name) {
              return field.name;
            }

            return field;
          },
          reset: function reset() {
            var emitEvent = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;
            this.columnFilters = {};

            if (emitEvent) {
              this.$emit('filter-changed', this.columnFilters);
            }
          },
          isFilterable: function isFilterable(column) {
            return column.filterOptions && column.filterOptions.enabled;
          },
          isDropdown: function isDropdown(column) {
            return this.isFilterable(column) && column.filterOptions.filterDropdownItems && column.filterOptions.filterDropdownItems.length;
          },
          isDropdownObjects: function isDropdownObjects(column) {
            return this.isDropdown(column) && _typeof(column.filterOptions.filterDropdownItems[0]) === 'object';
          },
          isDropdownArray: function isDropdownArray(column) {
            return this.isDropdown(column) && _typeof(column.filterOptions.filterDropdownItems[0]) !== 'object';
          },
          getClasses: function getClasses(column) {
            var firstClass = 'filter-th';
            return column.filterOptions && column.filterOptions.styleClass ? [firstClass].concat(_toConsumableArray(column.filterOptions.styleClass.split(' '))).join(' ') : firstClass;
          },
          // get column's defined placeholder or default one
          getPlaceholder: function getPlaceholder(column) {
            var placeholder = this.isFilterable(column) && column.filterOptions.placeholder || "Filter ".concat(column.label);
            return placeholder;
          },
          getName: function getName(column) {
            return "vgt-".concat(this.fieldKey(column.field));
          },
          updateFiltersOnEnter: function updateFiltersOnEnter(column, value) {
            if (this.timer) clearTimeout(this.timer);
            this.updateFiltersImmediately(column.field, value);
          },
          updateFiltersOnKeyup: function updateFiltersOnKeyup(column, value) {
            // if the trigger is enter, we don't filter on keyup
            if (column.filterOptions.trigger === 'enter') return;
            this.updateFilters(column, value);
          },
          updateSlotFilter: function updateSlotFilter(column, value) {
            var fieldToFilter = column.filterOptions.slotFilterField || column.field;

            if (typeof column.filterOptions.formatValue === 'function') {
              value = column.filterOptions.formatValue(value);
            }

            this.updateFiltersImmediately(fieldToFilter, value);
          },
          // since vue doesn't detect property addition and deletion, we
          // need to create helper function to set property etc
          updateFilters: function updateFilters(column, value) {
            var _this = this;

            if (this.timer) clearTimeout(this.timer);
            this.timer = setTimeout(function () {
              _this.updateFiltersImmediately(column.field, value);
            }, 400);
          },
          updateFiltersImmediately: function updateFiltersImmediately(field, value) {
            this.$set(this.columnFilters, this.fieldKey(field), value);
            this.$emit('filter-changed', this.columnFilters);
          },
          populateInitialFilters: function populateInitialFilters() {
            for (var i = 0; i < this.columns.length; i++) {
              var col = this.columns[i]; // lets see if there are initial
              // filters supplied by user

              if (this.isFilterable(col) && typeof col.filterOptions.filterValue !== 'undefined' && col.filterOptions.filterValue !== null) {
                this.$set(this.columnFilters, this.fieldKey(col.field), col.filterOptions.filterValue); // this.updateFilters(col, col.filterOptions.filterValue);
                // this.$set(col.filterOptions, 'filterValue', undefined);
              }
            } //* lets emit event once all filters are set


            this.$emit('filter-changed', this.columnFilters);
          }
        }
      };

      /* script */
      var __vue_script__$3 = script$3;
      /* template */

      var __vue_render__$3 = function __vue_render__() {
        var _vm = this;

        var _h = _vm.$createElement;

        var _c = _vm._self._c || _h;

        return _vm.hasFilterRow ? _c('tr', [_vm.lineNumbers ? _c('th') : _vm._e(), _vm._v(" "), _vm.selectable ? _c('th') : _vm._e(), _vm._v(" "), _vm._l(_vm.columns, function (column, index) {
          return !column.hidden ? _c('th', {
            key: index,
            "class": _vm.getClasses(column)
          }, [_vm._t("column-filter", [_vm.isFilterable(column) ? _c('div', [!_vm.isDropdown(column) ? _c('input', {
            staticClass: "vgt-input",
            attrs: {
              "name": _vm.getName(column),
              "type": "text",
              "placeholder": _vm.getPlaceholder(column)
            },
            domProps: {
              "value": _vm.columnFilters[_vm.fieldKey(column.field)]
            },
            on: {
              "keyup": function keyup($event) {
                if (!$event.type.indexOf('key') && _vm._k($event.keyCode, "enter", 13, $event.key, "Enter")) {
                  return null;
                }

                return _vm.updateFiltersOnEnter(column, $event.target.value);
              },
              "input": function input($event) {
                return _vm.updateFiltersOnKeyup(column, $event.target.value);
              }
            }
          }) : _vm._e(), _vm._v(" "), _vm.isDropdownArray(column) ? _c('select', {
            staticClass: "vgt-select",
            attrs: {
              "name": _vm.getName(column)
            },
            domProps: {
              "value": _vm.columnFilters[_vm.fieldKey(column.field)]
            },
            on: {
              "change": function change($event) {
                return _vm.updateFiltersImmediately(column.field, $event.target.value);
              }
            }
          }, [_c('option', {
            key: "-1",
            attrs: {
              "value": ""
            }
          }, [_vm._v(_vm._s(_vm.getPlaceholder(column)))]), _vm._v(" "), _vm._l(column.filterOptions.filterDropdownItems, function (option, i) {
            return _c('option', {
              key: i,
              domProps: {
                "value": option
              }
            }, [_vm._v("\n              " + _vm._s(option) + "\n            ")]);
          })], 2) : _vm._e(), _vm._v(" "), _vm.isDropdownObjects(column) ? _c('select', {
            staticClass: "vgt-select",
            attrs: {
              "name": _vm.getName(column)
            },
            domProps: {
              "value": _vm.columnFilters[_vm.fieldKey(column.field)]
            },
            on: {
              "change": function change($event) {
                return _vm.updateFiltersImmediately(column.field, $event.target.value);
              }
            }
          }, [_c('option', {
            key: "-1",
            attrs: {
              "value": ""
            }
          }, [_vm._v(_vm._s(_vm.getPlaceholder(column)))]), _vm._v(" "), _vm._l(column.filterOptions.filterDropdownItems, function (option, i) {
            return _c('option', {
              key: i,
              domProps: {
                "value": option.value
              }
            }, [_vm._v(_vm._s(option.text))]);
          })], 2) : _vm._e()]) : _vm._e()], {
            "column": column,
            "updateFilters": _vm.updateSlotFilter
          })], 2) : _vm._e();
        })], 2) : _vm._e();
      };

      var __vue_staticRenderFns__$3 = [];
      /* style */

      var __vue_inject_styles__$3 = undefined;
      /* scoped */

      var __vue_scope_id__$3 = "data-v-6869bf1c";
      /* module identifier */

      var __vue_module_identifier__$3 = undefined;
      /* functional template */

      var __vue_is_functional_template__$3 = false;
      /* style inject */

      /* style inject SSR */

      /* style inject shadow dom */

      var __vue_component__$3 = /*#__PURE__*/normalizeComponent({
        render: __vue_render__$3,
        staticRenderFns: __vue_staticRenderFns__$3
      }, __vue_inject_styles__$3, __vue_script__$3, __vue_scope_id__$3, __vue_is_functional_template__$3, __vue_module_identifier__$3, false, undefined, undefined, undefined);

      function getColumnFirstSortType(column) {
        return column.firstSortType || DEFAULT_SORT_TYPE;
      }

      function getCurrentPrimarySort(sortArray, column) {
        return sortArray.length === 1 && sortArray[0].field === column.field ? sortArray[0].type : undefined;
      }

      function getNextSort(currentSort, column) {
        if (SORT_TYPES.Descending === getColumnFirstSortType(column) && currentSort === SORT_TYPES.Ascending) {
          return SORT_TYPES.None;
        } else if (currentSort === SORT_TYPES.Ascending) {
          return SORT_TYPES.Descending;
        }

        if (SORT_TYPES.Descending === getColumnFirstSortType(column) && currentSort === SORT_TYPES.Descending) {
          return SORT_TYPES.Ascending;
        } else if (currentSort === SORT_TYPES.Descending) {
          return SORT_TYPES.None;
        }

        if (SORT_TYPES.Descending === getColumnFirstSortType(column) && currentSort === SORT_TYPES.None) {
          return SORT_TYPES.Descending;
        } else {
          return SORT_TYPES.Ascending;
        }
      }

      function getIndex(sortArray, column) {
        for (var i = 0; i < sortArray.length; i++) {
          if (column.field === sortArray[i].field) return i;
        }

        return -1;
      }

      var primarySort = function primarySort(sortArray, column) {
        var currentPrimarySort = getCurrentPrimarySort(sortArray, column);
        var nextPrimarySort = getNextSort(currentPrimarySort, column);
        return [{
          field: column.field,
          type: currentPrimarySort ? nextPrimarySort : getColumnFirstSortType(column)
        }];
      };

      var secondarySort = function secondarySort(sortArray, column) {
        var index = getIndex(sortArray, column);

        if (index === -1) {
          sortArray.push({
            field: column.field,
            type: getColumnFirstSortType(column)
          });
        } else {
          sortArray[index].type = getNextSort(sortArray[index].type, column);
        }

        return sortArray;
      };

//
      var script$4 = {
        name: 'VgtTableHeader',
        props: {
          lineNumbers: {
            "default": false,
            type: Boolean
          },
          selectable: {
            "default": false,
            type: Boolean
          },
          allSelected: {
            "default": false,
            type: Boolean
          },
          allSelectedIndeterminate: {
            "default": false,
            type: Boolean
          },
          columns: {
            type: Array
          },
          mode: {
            type: String
          },
          typedColumns: {},
          //* Sort related
          sortable: {
            type: Boolean
          },
          multipleColumnSort: {
            type: Boolean,
            "default": true
          },
          getClasses: {
            type: Function
          },
          //* search related
          searchEnabled: {
            type: Boolean
          },
          tableRef: {},
          paginated: {}
        },
        watch: {
          columns: {
            handler: function handler() {
              this.setColumnStyles();
            },
            immediate: true
          },
          tableRef: {
            handler: function handler() {
              this.setColumnStyles();
            },
            immediate: true
          },
          paginated: {
            handler: function handler() {
              if (this.tableRef) {
                this.setColumnStyles();
              }
            },
            deep: true
          }
        },
        data: function data() {
          return {
            checkBoxThStyle: {},
            lineNumberThStyle: {},
            columnStyles: [],
            sorts: [],
            ro: null
          };
        },
        computed: {},
        methods: {
          reset: function reset() {
            this.$refs['filter-row'].reset(true);
          },
          toggleSelectAll: function toggleSelectAll() {
            this.$emit('on-toggle-select-all');
          },
          isSortableColumn: function isSortableColumn(column) {
            var sortable = column.sortable;
            var isSortable = typeof sortable === 'boolean' ? sortable : this.sortable;
            return isSortable;
          },
          sort: function sort(e, column) {
            //* if column is not sortable, return right here
            if (!this.isSortableColumn(column)) return;

            if (e.shiftKey && this.multipleColumnSort) {
              this.sorts = secondarySort(this.sorts, column);
            } else {
              this.sorts = primarySort(this.sorts, column);
            }

            this.$emit('on-sort-change', this.sorts);
          },
          setInitialSort: function setInitialSort(sorts) {
            this.sorts = sorts;
            this.$emit('on-sort-change', this.sorts);
          },
          getColumnSort: function getColumnSort(column) {
            for (var i = 0; i < this.sorts.length; i += 1) {
              if (this.sorts[i].field === column.field) {
                return this.sorts[i].type || 'asc';
              }
            }

            return null;
          },
          getColumnSortLong: function getColumnSortLong(column) {
            return this.getColumnSort(column) === 'asc' ? 'ascending' : 'descending';
          },
          getHeaderClasses: function getHeaderClasses(column, index) {
            var classes = Object.assign({}, this.getClasses(index, 'th'), {
              sortable: this.isSortableColumn(column),
              'sorting sorting-desc': this.getColumnSort(column) === 'desc',
              'sorting sorting-asc': this.getColumnSort(column) === 'asc'
            });
            return classes;
          },
          filterRows: function filterRows(columnFilters) {
            this.$emit('filter-changed', columnFilters);
          },
          getWidthStyle: function getWidthStyle(dom) {
            if (window && window.getComputedStyle && dom) {
              var cellStyle = window.getComputedStyle(dom, null);
              return {
                width: cellStyle.width
              };
            }

            return {
              width: 'auto'
            };
          },
          setColumnStyles: function setColumnStyles() {
            var colStyles = [];

            for (var i = 0; i < this.columns.length; i++) {
              if (this.tableRef) {
                var skip = 0;
                if (this.selectable) skip++;
                if (this.lineNumbers) skip++;
                var cell = this.tableRef.rows[0].cells[i + skip];
                colStyles.push(this.getWidthStyle(cell));
              } else {
                colStyles.push({
                  minWidth: this.columns[i].width ? this.columns[i].width : 'auto',
                  maxWidth: this.columns[i].width ? this.columns[i].width : 'auto',
                  width: this.columns[i].width ? this.columns[i].width : 'auto'
                });
              }
            }

            this.columnStyles = colStyles;
          },
          getColumnStyle: function getColumnStyle(column, index) {
            var styleObject = {
              minWidth: column.width ? column.width : 'auto',
              maxWidth: column.width ? column.width : 'auto',
              width: column.width ? column.width : 'auto'
            }; //* if fixed header we need to get width from original table

            if (this.tableRef) {
              if (this.selectable) index++;
              if (this.lineNumbers) index++;
              var cell = this.tableRef.rows[0].cells[index];
              var cellStyle = window.getComputedStyle(cell, null);
              styleObject.width = cellStyle.width;
            }

            return styleObject;
          }
        },
        mounted: function mounted() {
          var _this = this;

          this.$nextTick(function () {
            // We're going to watch the parent element for resize events, and calculate column widths if it changes
            if ('ResizeObserver' in window) {
              _this.ro = new ResizeObserver(function () {
                _this.setColumnStyles();
              });

              _this.ro.observe(_this.$parent.$el); // If this is a fixed-header table, we want to observe each column header from the non-fixed header.
              // You can imagine two columns swapping widths, which wouldn't cause the above to trigger.
              // This gets the first tr element of the primary table header, and iterates through its children (the th elements)


              if (_this.tableRef) {
                Array.from(_this.$parent.$refs['table-header-primary'].$el.children[0].children).forEach(function (header) {
                  _this.ro.observe(header);
                });
              }
            }
          });
        },
        beforeDestroy: function beforeDestroy() {
          if (this.ro) {
            this.ro.disconnect();
          }
        },
        components: {
          'vgt-filter-row': __vue_component__$3
        }
      };

      /* script */
      var __vue_script__$4 = script$4;
      /* template */

      var __vue_render__$4 = function __vue_render__() {
        var _vm = this;

        var _h = _vm.$createElement;

        var _c = _vm._self._c || _h;

        return _c('thead', [_c('tr', [_vm.lineNumbers ? _c('th', {
          staticClass: "line-numbers",
          attrs: {
            "scope": "col"
          }
        }) : _vm._e(), _vm._v(" "), _vm.selectable ? _c('th', {
          staticClass: "vgt-checkbox-col",
          attrs: {
            "scope": "col"
          }
        }, [_c('input', {
          attrs: {
            "type": "checkbox"
          },
          domProps: {
            "checked": _vm.allSelected,
            "indeterminate": _vm.allSelectedIndeterminate
          },
          on: {
            "change": _vm.toggleSelectAll
          }
        })]) : _vm._e(), _vm._v(" "), _vm._l(_vm.columns, function (column, index) {
          return !column.hidden ? _c('th', {
            key: index,
            "class": _vm.getHeaderClasses(column, index),
            style: _vm.columnStyles[index],
            attrs: {
              "scope": "col",
              "title": column.tooltip,
              "aria-sort": _vm.getColumnSortLong(column),
              "aria-controls": "col-" + index
            }
          }, [_vm._t("table-column", [_vm._v("\n        " + _vm._s(column.label) + "\n      ")], {
            "column": column
          }), _vm._v(" "), _vm.isSortableColumn(column) ? _c('button', {
            on: {
              "click": function click($event) {
                return _vm.sort($event, column);
              }
            }
          }, [_c('span', {
            staticClass: "sr-only"
          }, [_vm._v("\n          Sort table by " + _vm._s(column.label) + " in " + _vm._s(_vm.getColumnSortLong(column)) + " order\n          ")])]) : _vm._e()], 2) : _vm._e();
        })], 2), _vm._v(" "), _c("vgt-filter-row", {
          ref: "filter-row",
          tag: "tr",
          attrs: {
            "global-search-enabled": _vm.searchEnabled,
            "line-numbers": _vm.lineNumbers,
            "selectable": _vm.selectable,
            "columns": _vm.columns,
            "mode": _vm.mode,
            "typed-columns": _vm.typedColumns
          },
          on: {
            "filter-changed": _vm.filterRows
          },
          scopedSlots: _vm._u([{
            key: "column-filter",
            fn: function fn(props) {
              return [_vm._t("column-filter", null, {
                "column": props.column,
                "updateFilters": props.updateFilters
              })];
            }
          }], null, true)
        })], 1);
      };

      var __vue_staticRenderFns__$4 = [];
      /* style */

      var __vue_inject_styles__$4 = undefined;
      /* scoped */

      var __vue_scope_id__$4 = undefined;
      /* module identifier */

      var __vue_module_identifier__$4 = undefined;
      /* functional template */

      var __vue_is_functional_template__$4 = false;
      /* style inject */

      /* style inject SSR */

      /* style inject shadow dom */

      var __vue_component__$4 = /*#__PURE__*/normalizeComponent({
        render: __vue_render__$4,
        staticRenderFns: __vue_staticRenderFns__$4
      }, __vue_inject_styles__$4, __vue_script__$4, __vue_scope_id__$4, __vue_is_functional_template__$4, __vue_module_identifier__$4, false, undefined, undefined, undefined);

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
      var script$5 = {
        name: 'VgtHeaderRow',
        props: {
          headerRow: {
            type: Object
          },
          columns: {
            type: Array
          },
          lineNumbers: {
            type: Boolean
          },
          selectable: {
            type: Boolean
          },
          selectAllByGroup: {
            type: Boolean
          },
          collapsable: {
            type: [Boolean, Number],
            "default": false
          },
          collectFormatted: {
            type: Function
          },
          formattedRow: {
            type: Function
          },
          getClasses: {
            type: Function
          },
          fullColspan: {
            type: Number
          },
          groupIndex: {
            type: Number
          }
        },
        data: function data() {
          return {};
        },
        computed: {
          allSelected: function allSelected() {
            var headerRow = this.headerRow,
                groupChildObject = this.groupChildObject;
            return headerRow.children.filter(function (row) {
              return row.vgtSelected;
            }).length === headerRow.children.length;
          }
        },
        methods: {
          columnCollapsable: function columnCollapsable(currentIndex) {
            if (this.collapsable === true) {
              return currentIndex === 0;
            }

            return currentIndex === this.collapsable;
          },
          toggleSelectGroup: function toggleSelectGroup(event) {
            this.$emit('on-select-group-change', {
              groupIndex: this.groupIndex,
              checked: event.target.checked
            });
          }
        },
        mounted: function mounted() {},
        components: {}
      };

      /* script */
      var __vue_script__$5 = script$5;
      /* template */

      var __vue_render__$5 = function __vue_render__() {
        var _vm = this;

        var _h = _vm.$createElement;

        var _c = _vm._self._c || _h;

        return _c('tr', [_vm.headerRow.mode === 'span' ? _c('th', {
          staticClass: "vgt-left-align vgt-row-header",
          attrs: {
            "colspan": _vm.fullColspan
          }
        }, [_vm.selectAllByGroup ? [_vm._t("table-header-group-select", [_c('input', {
          attrs: {
            "type": "checkbox"
          },
          domProps: {
            "checked": _vm.allSelected
          },
          on: {
            "change": function change($event) {
              return _vm.toggleSelectGroup($event);
            }
          }
        })], {
          "columns": _vm.columns,
          "row": _vm.headerRow
        })] : _vm._e(), _vm._v(" "), _c('span', {
          on: {
            "click": function click($event) {
              _vm.collapsable ? _vm.$emit('vgtExpand', !_vm.headerRow.vgtIsExpanded) : function () {};
            }
          }
        }, [_vm.collapsable ? _c('span', {
          staticClass: "triangle",
          "class": {
            'expand': _vm.headerRow.vgtIsExpanded
          }
        }) : _vm._e(), _vm._v(" "), _vm._t("table-header-row", [_vm.headerRow.html ? _c('span', {
          domProps: {
            "innerHTML": _vm._s(_vm.headerRow.label)
          }
        }) : _c('span', [_vm._v("\n          " + _vm._s(_vm.headerRow.label) + "\n        ")])], {
          "row": _vm.headerRow
        })], 2)], 2) : _vm._e(), _vm._v(" "), _vm.headerRow.mode !== 'span' && _vm.lineNumbers ? _c('th', {
          staticClass: "vgt-row-header"
        }) : _vm._e(), _vm._v(" "), _vm.headerRow.mode !== 'span' && _vm.selectable ? _c('th', {
          staticClass: "vgt-row-header"
        }, [_vm.selectAllByGroup ? [_vm._t("table-header-group-select", [_c('input', {
          attrs: {
            "type": "checkbox"
          },
          domProps: {
            "checked": _vm.allSelected
          },
          on: {
            "change": function change($event) {
              return _vm.toggleSelectGroup($event);
            }
          }
        })], {
          "columns": _vm.columns,
          "row": _vm.headerRow
        })] : _vm._e()], 2) : _vm._e(), _vm._v(" "), _vm._l(_vm.columns, function (column, i) {
          return _vm.headerRow.mode !== 'span' && !column.hidden ? _c('th', {
            key: i,
            staticClass: "vgt-row-header",
            "class": _vm.getClasses(i, 'td'),
            on: {
              "click": function click($event) {
                _vm.columnCollapsable(i) ? _vm.$emit('vgtExpand', !_vm.headerRow.vgtIsExpanded) : function () {};
              }
            }
          }, [_vm.columnCollapsable(i) ? _c('span', {
            staticClass: "triangle",
            "class": {
              'expand': _vm.headerRow.vgtIsExpanded
            }
          }) : _vm._e(), _vm._v(" "), _vm._t("table-header-row", [!column.html ? _c('span', [_vm._v("\n        " + _vm._s(_vm.collectFormatted(_vm.headerRow, column, true)) + "\n      ")]) : _vm._e(), _vm._v(" "), column.html ? _c('span', {
            domProps: {
              "innerHTML": _vm._s(_vm.collectFormatted(_vm.headerRow, column, true))
            }
          }) : _vm._e()], {
            "row": _vm.headerRow,
            "column": column,
            "formattedRow": _vm.formattedRow(_vm.headerRow, true)
          })], 2) : _vm._e();
        })], 2);
      };

      var __vue_staticRenderFns__$5 = [];
      /* style */

      var __vue_inject_styles__$5 = undefined;
      /* scoped */

      var __vue_scope_id__$5 = undefined;
      /* module identifier */

      var __vue_module_identifier__$5 = undefined;
      /* functional template */

      var __vue_is_functional_template__$5 = false;
      /* style inject */

      /* style inject SSR */

      /* style inject shadow dom */

      var __vue_component__$5 = /*#__PURE__*/normalizeComponent({
        render: __vue_render__$5,
        staticRenderFns: __vue_staticRenderFns__$5
      }, __vue_inject_styles__$5, __vue_script__$5, __vue_scope_id__$5, __vue_is_functional_template__$5, __vue_module_identifier__$5, false, undefined, undefined, undefined);

      function toInteger(dirtyNumber) {
        if (dirtyNumber === null || dirtyNumber === true || dirtyNumber === false) {
          return NaN;
        }

        var number = Number(dirtyNumber);

        if (isNaN(number)) {
          return number;
        }

        return number < 0 ? Math.ceil(number) : Math.floor(number);
      }

      function requiredArgs(required, args) {
        if (args.length < required) {
          throw new TypeError(required + ' argument' + (required > 1 ? 's' : '') + ' required, but only ' + args.length + ' present');
        }
      }

      /**
       * @name toDate
       * @category Common Helpers
       * @summary Convert the given argument to an instance of Date.
       *
       * @description
       * Convert the given argument to an instance of Date.
       *
       * If the argument is an instance of Date, the function returns its clone.
       *
       * If the argument is a number, it is treated as a timestamp.
       *
       * If the argument is none of the above, the function returns Invalid Date.
       *
       * **Note**: *all* Date arguments passed to any *date-fns* function is processed by `toDate`.
       *
       * @param {Date|Number} argument - the value to convert
       * @returns {Date} the parsed date in the local time zone
       * @throws {TypeError} 1 argument required
       *
       * @example
       * // Clone the date:
       * const result = toDate(new Date(2014, 1, 11, 11, 30, 30))
       * //=> Tue Feb 11 2014 11:30:30
       *
       * @example
       * // Convert the timestamp to date:
       * const result = toDate(1392098430000)
       * //=> Tue Feb 11 2014 11:30:30
       */

      function toDate(argument) {
        requiredArgs(1, arguments);
        var argStr = Object.prototype.toString.call(argument); // Clone the date

        if (argument instanceof Date || typeof argument === 'object' && argStr === '[object Date]') {
          // Prevent the date to lose the milliseconds when passed to new Date() in IE10
          return new Date(argument.getTime());
        } else if (typeof argument === 'number' || argStr === '[object Number]') {
          return new Date(argument);
        } else {
          if ((typeof argument === 'string' || argStr === '[object String]') && typeof console !== 'undefined') {
            // eslint-disable-next-line no-console
            console.warn("Starting with v2.0.0-beta.1 date-fns doesn't accept strings as date arguments. Please use `parseISO` to parse strings. See: https://git.io/fjule"); // eslint-disable-next-line no-console

            console.warn(new Error().stack);
          }

          return new Date(NaN);
        }
      }

      /**
       * @name addMilliseconds
       * @category Millisecond Helpers
       * @summary Add the specified number of milliseconds to the given date.
       *
       * @description
       * Add the specified number of milliseconds to the given date.
       *
       * ### v2.0.0 breaking changes:
       *
       * - [Changes that are common for the whole library](https://github.com/date-fns/date-fns/blob/master/docs/upgradeGuide.md#Common-Changes).
       *
       * @param {Date|Number} date - the date to be changed
       * @param {Number} amount - the amount of milliseconds to be added. Positive decimals will be rounded using `Math.floor`, decimals less than zero will be rounded using `Math.ceil`.
       * @returns {Date} the new date with the milliseconds added
       * @throws {TypeError} 2 arguments required
       *
       * @example
       * // Add 750 milliseconds to 10 July 2014 12:45:30.000:
       * const result = addMilliseconds(new Date(2014, 6, 10, 12, 45, 30, 0), 750)
       * //=> Thu Jul 10 2014 12:45:30.750
       */

      function addMilliseconds(dirtyDate, dirtyAmount) {
        requiredArgs(2, arguments);
        var timestamp = toDate(dirtyDate).getTime();
        var amount = toInteger(dirtyAmount);
        return new Date(timestamp + amount);
      }

      var MILLISECONDS_IN_MINUTE = 60000;

      function getDateMillisecondsPart(date) {
        return date.getTime() % MILLISECONDS_IN_MINUTE;
      }
      /**
       * Google Chrome as of 67.0.3396.87 introduced timezones with offset that includes seconds.
       * They usually appear for dates that denote time before the timezones were introduced
       * (e.g. for 'Europe/Prague' timezone the offset is GMT+00:57:44 before 1 October 1891
       * and GMT+01:00:00 after that date)
       *
       * Date#getTimezoneOffset returns the offset in minutes and would return 57 for the example above,
       * which would lead to incorrect calculations.
       *
       * This function returns the timezone offset in milliseconds that takes seconds in account.
       */


      function getTimezoneOffsetInMilliseconds(dirtyDate) {
        var date = new Date(dirtyDate.getTime());
        var baseTimezoneOffset = Math.ceil(date.getTimezoneOffset());
        date.setSeconds(0, 0);
        var hasNegativeUTCOffset = baseTimezoneOffset > 0;
        var millisecondsPartOfTimezoneOffset = hasNegativeUTCOffset ? (MILLISECONDS_IN_MINUTE + getDateMillisecondsPart(date)) % MILLISECONDS_IN_MINUTE : getDateMillisecondsPart(date);
        return baseTimezoneOffset * MILLISECONDS_IN_MINUTE + millisecondsPartOfTimezoneOffset;
      }

      /**
       * @name compareAsc
       * @category Common Helpers
       * @summary Compare the two dates and return -1, 0 or 1.
       *
       * @description
       * Compare the two dates and return 1 if the first date is after the second,
       * -1 if the first date is before the second or 0 if dates are equal.
       *
       * ### v2.0.0 breaking changes:
       *
       * - [Changes that are common for the whole library](https://github.com/date-fns/date-fns/blob/master/docs/upgradeGuide.md#Common-Changes).
       *
       * @param {Date|Number} dateLeft - the first date to compare
       * @param {Date|Number} dateRight - the second date to compare
       * @returns {Number} the result of the comparison
       * @throws {TypeError} 2 arguments required
       *
       * @example
       * // Compare 11 February 1987 and 10 July 1989:
       * const result = compareAsc(new Date(1987, 1, 11), new Date(1989, 6, 10))
       * //=> -1
       *
       * @example
       * // Sort the array of dates:
       * const result = [
       *   new Date(1995, 6, 2),
       *   new Date(1987, 1, 11),
       *   new Date(1989, 6, 10)
       * ].sort(compareAsc)
       * //=> [
       * //   Wed Feb 11 1987 00:00:00,
       * //   Mon Jul 10 1989 00:00:00,
       * //   Sun Jul 02 1995 00:00:00
       * // ]
       */

      function compareAsc(dirtyDateLeft, dirtyDateRight) {
        requiredArgs(2, arguments);
        var dateLeft = toDate(dirtyDateLeft);
        var dateRight = toDate(dirtyDateRight);
        var diff = dateLeft.getTime() - dateRight.getTime();

        if (diff < 0) {
          return -1;
        } else if (diff > 0) {
          return 1; // Return 0 if diff is 0; return NaN if diff is NaN
        } else {
          return diff;
        }
      }

      /**
       * @name isValid
       * @category Common Helpers
       * @summary Is the given date valid?
       *
       * @description
       * Returns false if argument is Invalid Date and true otherwise.
       * Argument is converted to Date using `toDate`. See [toDate]{@link https://date-fns.org/docs/toDate}
       * Invalid Date is a Date, whose time value is NaN.
       *
       * Time value of Date: http://es5.github.io/#x15.9.1.1
       *
       * ### v2.0.0 breaking changes:
       *
       * - [Changes that are common for the whole library](https://github.com/date-fns/date-fns/blob/master/docs/upgradeGuide.md#Common-Changes).
       *
       * - Now `isValid` doesn't throw an exception
       *   if the first argument is not an instance of Date.
       *   Instead, argument is converted beforehand using `toDate`.
       *
       *   Examples:
       *
       *   | `isValid` argument        | Before v2.0.0 | v2.0.0 onward |
       *   |---------------------------|---------------|---------------|
       *   | `new Date()`              | `true`        | `true`        |
       *   | `new Date('2016-01-01')`  | `true`        | `true`        |
       *   | `new Date('')`            | `false`       | `false`       |
       *   | `new Date(1488370835081)` | `true`        | `true`        |
       *   | `new Date(NaN)`           | `false`       | `false`       |
       *   | `'2016-01-01'`            | `TypeError`   | `false`       |
       *   | `''`                      | `TypeError`   | `false`       |
       *   | `1488370835081`           | `TypeError`   | `true`        |
       *   | `NaN`                     | `TypeError`   | `false`       |
       *
       *   We introduce this change to make *date-fns* consistent with ECMAScript behavior
       *   that try to coerce arguments to the expected type
       *   (which is also the case with other *date-fns* functions).
       *
       * @param {*} date - the date to check
       * @returns {Boolean} the date is valid
       * @throws {TypeError} 1 argument required
       *
       * @example
       * // For the valid date:
       * var result = isValid(new Date(2014, 1, 31))
       * //=> true
       *
       * @example
       * // For the value, convertable into a date:
       * var result = isValid(1393804800000)
       * //=> true
       *
       * @example
       * // For the invalid date:
       * var result = isValid(new Date(''))
       * //=> false
       */

      function isValid(dirtyDate) {
        requiredArgs(1, arguments);
        var date = toDate(dirtyDate);
        return !isNaN(date);
      }

      function inArray(needle, haystack) {
        var length = haystack.length;
        for(var i = 0; i < length; i++) {
          if(haystack[i] == needle) return true;
        }
        return false;
      }

      function getSortOptions() {
        var pathname = window.location.pathname;
        var pages_asc = [
          '/admin/entity/post_categories',
          '/admin/entity/product_categories',
          '/admin/entity/products',
          '/admin/entity/index_sliders',
          '/admin/entity/calculators',
          '/admin/entity/calculators',
          '/admin/entity/akcii_slider'
        ]
        if(inArray(pathname,pages_asc))
          return  { field: "id", type: "asc" };
        else
          return  { field: "id", type: "desc" };
      }

      var formatDistanceLocale = {
        lessThanXSeconds: {
          one: 'less than a second',
          other: 'less than {{count}} seconds'
        },
        xSeconds: {
          one: '1 second',
          other: '{{count}} seconds'
        },
        halfAMinute: 'half a minute',
        lessThanXMinutes: {
          one: 'less than a minute',
          other: 'less than {{count}} minutes'
        },
        xMinutes: {
          one: '1 minute',
          other: '{{count}} minutes'
        },
        aboutXHours: {
          one: 'about 1 hour',
          other: 'about {{count}} hours'
        },
        xHours: {
          one: '1 hour',
          other: '{{count}} hours'
        },
        xDays: {
          one: '1 day',
          other: '{{count}} days'
        },
        aboutXWeeks: {
          one: 'about 1 week',
          other: 'about {{count}} weeks'
        },
        xWeeks: {
          one: '1 week',
          other: '{{count}} weeks'
        },
        aboutXMonths: {
          one: 'about 1 month',
          other: 'about {{count}} months'
        },
        xMonths: {
          one: '1 month',
          other: '{{count}} months'
        },
        aboutXYears: {
          one: 'about 1 year',
          other: 'about {{count}} years'
        },
        xYears: {
          one: '1 year',
          other: '{{count}} years'
        },
        overXYears: {
          one: 'over 1 year',
          other: 'over {{count}} years'
        },
        almostXYears: {
          one: 'almost 1 year',
          other: 'almost {{count}} years'
        }
      };
      function formatDistance(token, count, options) {
        options = options || {};
        var result;

        if (typeof formatDistanceLocale[token] === 'string') {
          result = formatDistanceLocale[token];
        } else if (count === 1) {
          result = formatDistanceLocale[token].one;
        } else {
          result = formatDistanceLocale[token].other.replace('{{count}}', count);
        }

        if (options.addSuffix) {
          if (options.comparison > 0) {
            return 'in ' + result;
          } else {
            return result + ' ago';
          }
        }

        return result;
      }

      function buildFormatLongFn(args) {
        return function (dirtyOptions) {
          var options = dirtyOptions || {};
          var width = options.width ? String(options.width) : args.defaultWidth;
          var format = args.formats[width] || args.formats[args.defaultWidth];
          return format;
        };
      }

      var dateFormats = {
        full: 'EEEE, MMMM do, y',
        long: 'MMMM do, y',
        medium: 'MMM d, y',
        short: 'MM/dd/yyyy'
      };
      var timeFormats = {
        full: 'h:mm:ss a zzzz',
        long: 'h:mm:ss a z',
        medium: 'h:mm:ss a',
        short: 'h:mm a'
      };
      var dateTimeFormats = {
        full: "{{date}} 'at' {{time}}",
        long: "{{date}} 'at' {{time}}",
        medium: '{{date}}, {{time}}',
        short: '{{date}}, {{time}}'
      };
      var formatLong = {
        date: buildFormatLongFn({
          formats: dateFormats,
          defaultWidth: 'full'
        }),
        time: buildFormatLongFn({
          formats: timeFormats,
          defaultWidth: 'full'
        }),
        dateTime: buildFormatLongFn({
          formats: dateTimeFormats,
          defaultWidth: 'full'
        })
      };

      var formatRelativeLocale = {
        lastWeek: "'last' eeee 'at' p",
        yesterday: "'yesterday at' p",
        today: "'today at' p",
        tomorrow: "'tomorrow at' p",
        nextWeek: "eeee 'at' p",
        other: 'P'
      };
      function formatRelative(token, _date, _baseDate, _options) {
        return formatRelativeLocale[token];
      }

      function buildLocalizeFn(args) {
        return function (dirtyIndex, dirtyOptions) {
          var options = dirtyOptions || {};
          var context = options.context ? String(options.context) : 'standalone';
          var valuesArray;

          if (context === 'formatting' && args.formattingValues) {
            var defaultWidth = args.defaultFormattingWidth || args.defaultWidth;
            var width = options.width ? String(options.width) : defaultWidth;
            valuesArray = args.formattingValues[width] || args.formattingValues[defaultWidth];
          } else {
            var _defaultWidth = args.defaultWidth;

            var _width = options.width ? String(options.width) : args.defaultWidth;

            valuesArray = args.values[_width] || args.values[_defaultWidth];
          }

          var index = args.argumentCallback ? args.argumentCallback(dirtyIndex) : dirtyIndex;
          return valuesArray[index];
        };
      }

      var eraValues = {
        narrow: ['B', 'A'],
        abbreviated: ['BC', 'AD'],
        wide: ['Before Christ', 'Anno Domini']
      };
      var quarterValues = {
        narrow: ['1', '2', '3', '4'],
        abbreviated: ['Q1', 'Q2', 'Q3', 'Q4'],
        wide: ['1st quarter', '2nd quarter', '3rd quarter', '4th quarter'] // Note: in English, the names of days of the week and months are capitalized.
        // If you are making a new locale based on this one, check if the same is true for the language you're working on.
        // Generally, formatted dates should look like they are in the middle of a sentence,
        // e.g. in Spanish language the weekdays and months should be in the lowercase.

      };
      var monthValues = {
        narrow: ['J', 'F', 'M', 'A', 'M', 'J', 'J', 'A', 'S', 'O', 'N', 'D'],
        abbreviated: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        wide: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
      };
      var dayValues = {
        narrow: ['S', 'M', 'T', 'W', 'T', 'F', 'S'],
        short: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
        abbreviated: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
        wide: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']
      };
      var dayPeriodValues = {
        narrow: {
          am: 'a',
          pm: 'p',
          midnight: 'mi',
          noon: 'n',
          morning: 'morning',
          afternoon: 'afternoon',
          evening: 'evening',
          night: 'night'
        },
        abbreviated: {
          am: 'AM',
          pm: 'PM',
          midnight: 'midnight',
          noon: 'noon',
          morning: 'morning',
          afternoon: 'afternoon',
          evening: 'evening',
          night: 'night'
        },
        wide: {
          am: 'a.m.',
          pm: 'p.m.',
          midnight: 'midnight',
          noon: 'noon',
          morning: 'morning',
          afternoon: 'afternoon',
          evening: 'evening',
          night: 'night'
        }
      };
      var formattingDayPeriodValues = {
        narrow: {
          am: 'a',
          pm: 'p',
          midnight: 'mi',
          noon: 'n',
          morning: 'in the morning',
          afternoon: 'in the afternoon',
          evening: 'in the evening',
          night: 'at night'
        },
        abbreviated: {
          am: 'AM',
          pm: 'PM',
          midnight: 'midnight',
          noon: 'noon',
          morning: 'in the morning',
          afternoon: 'in the afternoon',
          evening: 'in the evening',
          night: 'at night'
        },
        wide: {
          am: 'a.m.',
          pm: 'p.m.',
          midnight: 'midnight',
          noon: 'noon',
          morning: 'in the morning',
          afternoon: 'in the afternoon',
          evening: 'in the evening',
          night: 'at night'
        }
      };

      function ordinalNumber(dirtyNumber, _dirtyOptions) {
        var number = Number(dirtyNumber); // If ordinal numbers depend on context, for example,
        // if they are different for different grammatical genders,
        // use `options.unit`:
        //
        //   var options = dirtyOptions || {}
        //   var unit = String(options.unit)
        //
        // where `unit` can be 'year', 'quarter', 'month', 'week', 'date', 'dayOfYear',
        // 'day', 'hour', 'minute', 'second'

        var rem100 = number % 100;

        if (rem100 > 20 || rem100 < 10) {
          switch (rem100 % 10) {
            case 1:
              return number + 'st';

            case 2:
              return number + 'nd';

            case 3:
              return number + 'rd';
          }
        }

        return number + 'th';
      }

      var localize = {
        ordinalNumber: ordinalNumber,
        era: buildLocalizeFn({
          values: eraValues,
          defaultWidth: 'wide'
        }),
        quarter: buildLocalizeFn({
          values: quarterValues,
          defaultWidth: 'wide',
          argumentCallback: function (quarter) {
            return Number(quarter) - 1;
          }
        }),
        month: buildLocalizeFn({
          values: monthValues,
          defaultWidth: 'wide'
        }),
        day: buildLocalizeFn({
          values: dayValues,
          defaultWidth: 'wide'
        }),
        dayPeriod: buildLocalizeFn({
          values: dayPeriodValues,
          defaultWidth: 'wide',
          formattingValues: formattingDayPeriodValues,
          defaultFormattingWidth: 'wide'
        })
      };

      function buildMatchPatternFn(args) {
        return function (dirtyString, dirtyOptions) {
          var string = String(dirtyString);
          var options = dirtyOptions || {};
          var matchResult = string.match(args.matchPattern);

          if (!matchResult) {
            return null;
          }

          var matchedString = matchResult[0];
          var parseResult = string.match(args.parsePattern);

          if (!parseResult) {
            return null;
          }

          var value = args.valueCallback ? args.valueCallback(parseResult[0]) : parseResult[0];
          value = options.valueCallback ? options.valueCallback(value) : value;
          return {
            value: value,
            rest: string.slice(matchedString.length)
          };
        };
      }

      function buildMatchFn(args) {
        return function (dirtyString, dirtyOptions) {
          var string = String(dirtyString);
          var options = dirtyOptions || {};
          var width = options.width;
          var matchPattern = width && args.matchPatterns[width] || args.matchPatterns[args.defaultMatchWidth];
          var matchResult = string.match(matchPattern);

          if (!matchResult) {
            return null;
          }

          var matchedString = matchResult[0];
          var parsePatterns = width && args.parsePatterns[width] || args.parsePatterns[args.defaultParseWidth];
          var value;

          if (Object.prototype.toString.call(parsePatterns) === '[object Array]') {
            value = findIndex(parsePatterns, function (pattern) {
              return pattern.test(matchedString);
            });
          } else {
            value = findKey(parsePatterns, function (pattern) {
              return pattern.test(matchedString);
            });
          }

          value = args.valueCallback ? args.valueCallback(value) : value;
          value = options.valueCallback ? options.valueCallback(value) : value;
          return {
            value: value,
            rest: string.slice(matchedString.length)
          };
        };
      }

      function findKey(object, predicate) {
        for (var key in object) {
          if (object.hasOwnProperty(key) && predicate(object[key])) {
            return key;
          }
        }
      }

      function findIndex(array, predicate) {
        for (var key = 0; key < array.length; key++) {
          if (predicate(array[key])) {
            return key;
          }
        }
      }

      var matchOrdinalNumberPattern = /^(\d+)(th|st|nd|rd)?/i;
      var parseOrdinalNumberPattern = /\d+/i;
      var matchEraPatterns = {
        narrow: /^(b|a)/i,
        abbreviated: /^(b\.?\s?c\.?|b\.?\s?c\.?\s?e\.?|a\.?\s?d\.?|c\.?\s?e\.?)/i,
        wide: /^(before christ|before common era|anno domini|common era)/i
      };
      var parseEraPatterns = {
        any: [/^b/i, /^(a|c)/i]
      };
      var matchQuarterPatterns = {
        narrow: /^[1234]/i,
        abbreviated: /^q[1234]/i,
        wide: /^[1234](th|st|nd|rd)? quarter/i
      };
      var parseQuarterPatterns = {
        any: [/1/i, /2/i, /3/i, /4/i]
      };
      var matchMonthPatterns = {
        narrow: /^[jfmasond]/i,
        abbreviated: /^(jan|feb|mar|apr|may|jun|jul|aug|sep|oct|nov|dec)/i,
        wide: /^(january|february|march|april|may|june|july|august|september|october|november|december)/i
      };
      var parseMonthPatterns = {
        narrow: [/^j/i, /^f/i, /^m/i, /^a/i, /^m/i, /^j/i, /^j/i, /^a/i, /^s/i, /^o/i, /^n/i, /^d/i],
        any: [/^ja/i, /^f/i, /^mar/i, /^ap/i, /^may/i, /^jun/i, /^jul/i, /^au/i, /^s/i, /^o/i, /^n/i, /^d/i]
      };
      var matchDayPatterns = {
        narrow: /^[smtwf]/i,
        short: /^(su|mo|tu|we|th|fr|sa)/i,
        abbreviated: /^(sun|mon|tue|wed|thu|fri|sat)/i,
        wide: /^(sunday|monday|tuesday|wednesday|thursday|friday|saturday)/i
      };
      var parseDayPatterns = {
        narrow: [/^s/i, /^m/i, /^t/i, /^w/i, /^t/i, /^f/i, /^s/i],
        any: [/^su/i, /^m/i, /^tu/i, /^w/i, /^th/i, /^f/i, /^sa/i]
      };
      var matchDayPeriodPatterns = {
        narrow: /^(a|p|mi|n|(in the|at) (morning|afternoon|evening|night))/i,
        any: /^([ap]\.?\s?m\.?|midnight|noon|(in the|at) (morning|afternoon|evening|night))/i
      };
      var parseDayPeriodPatterns = {
        any: {
          am: /^a/i,
          pm: /^p/i,
          midnight: /^mi/i,
          noon: /^no/i,
          morning: /morning/i,
          afternoon: /afternoon/i,
          evening: /evening/i,
          night: /night/i
        }
      };
      var match = {
        ordinalNumber: buildMatchPatternFn({
          matchPattern: matchOrdinalNumberPattern,
          parsePattern: parseOrdinalNumberPattern,
          valueCallback: function (value) {
            return parseInt(value, 10);
          }
        }),
        era: buildMatchFn({
          matchPatterns: matchEraPatterns,
          defaultMatchWidth: 'wide',
          parsePatterns: parseEraPatterns,
          defaultParseWidth: 'any'
        }),
        quarter: buildMatchFn({
          matchPatterns: matchQuarterPatterns,
          defaultMatchWidth: 'wide',
          parsePatterns: parseQuarterPatterns,
          defaultParseWidth: 'any',
          valueCallback: function (index) {
            return index + 1;
          }
        }),
        month: buildMatchFn({
          matchPatterns: matchMonthPatterns,
          defaultMatchWidth: 'wide',
          parsePatterns: parseMonthPatterns,
          defaultParseWidth: 'any'
        }),
        day: buildMatchFn({
          matchPatterns: matchDayPatterns,
          defaultMatchWidth: 'wide',
          parsePatterns: parseDayPatterns,
          defaultParseWidth: 'any'
        }),
        dayPeriod: buildMatchFn({
          matchPatterns: matchDayPeriodPatterns,
          defaultMatchWidth: 'any',
          parsePatterns: parseDayPeriodPatterns,
          defaultParseWidth: 'any'
        })
      };

      /**
       * @type {Locale}
       * @category Locales
       * @summary English locale (United States).
       * @language English
       * @iso-639-2 eng
       * @author Sasha Koss [@kossnocorp]{@link https://github.com/kossnocorp}
       * @author Lesha Koss [@leshakoss]{@link https://github.com/leshakoss}
       */

      var locale = {
        code: 'en-US',
        formatDistance: formatDistance,
        formatLong: formatLong,
        formatRelative: formatRelative,
        localize: localize,
        match: match,
        options: {
          weekStartsOn: 0
          /* Sunday */
          ,
          firstWeekContainsDate: 1
        }
      };

      /**
       * @name subMilliseconds
       * @category Millisecond Helpers
       * @summary Subtract the specified number of milliseconds from the given date.
       *
       * @description
       * Subtract the specified number of milliseconds from the given date.
       *
       * ### v2.0.0 breaking changes:
       *
       * - [Changes that are common for the whole library](https://github.com/date-fns/date-fns/blob/master/docs/upgradeGuide.md#Common-Changes).
       *
       * @param {Date|Number} date - the date to be changed
       * @param {Number} amount - the amount of milliseconds to be subtracted. Positive decimals will be rounded using `Math.floor`, decimals less than zero will be rounded using `Math.ceil`.
       * @returns {Date} the new date with the milliseconds subtracted
       * @throws {TypeError} 2 arguments required
       *
       * @example
       * // Subtract 750 milliseconds from 10 July 2014 12:45:30.000:
       * const result = subMilliseconds(new Date(2014, 6, 10, 12, 45, 30, 0), 750)
       * //=> Thu Jul 10 2014 12:45:29.250
       */

      function subMilliseconds(dirtyDate, dirtyAmount) {
        requiredArgs(2, arguments);
        var amount = toInteger(dirtyAmount);
        return addMilliseconds(dirtyDate, -amount);
      }

      function addLeadingZeros(number, targetLength) {
        var sign = number < 0 ? '-' : '';
        var output = Math.abs(number).toString();

        while (output.length < targetLength) {
          output = '0' + output;
        }

        return sign + output;
      }

      /*
 * |     | Unit                           |     | Unit                           |
 * |-----|--------------------------------|-----|--------------------------------|
 * |  a  | AM, PM                         |  A* |                                |
 * |  d  | Day of month                   |  D  |                                |
 * |  h  | Hour [1-12]                    |  H  | Hour [0-23]                    |
 * |  m  | Minute                         |  M  | Month                          |
 * |  s  | Second                         |  S  | Fraction of second             |
 * |  y  | Year (abs)                     |  Y  |                                |
 *
 * Letters marked by * are not implemented but reserved by Unicode standard.
 */

      var formatters = {
        // Year
        y: function (date, token) {
          // From http://www.unicode.org/reports/tr35/tr35-31/tr35-dates.html#Date_Format_tokens
          // | Year     |     y | yy |   yyy |  yyyy | yyyyy |
          // |----------|-------|----|-------|-------|-------|
          // | AD 1     |     1 | 01 |   001 |  0001 | 00001 |
          // | AD 12    |    12 | 12 |   012 |  0012 | 00012 |
          // | AD 123   |   123 | 23 |   123 |  0123 | 00123 |
          // | AD 1234  |  1234 | 34 |  1234 |  1234 | 01234 |
          // | AD 12345 | 12345 | 45 | 12345 | 12345 | 12345 |
          var signedYear = date.getUTCFullYear(); // Returns 1 for 1 BC (which is year 0 in JavaScript)

          var year = signedYear > 0 ? signedYear : 1 - signedYear;
          return addLeadingZeros(token === 'yy' ? year % 100 : year, token.length);
        },
        // Month
        M: function (date, token) {
          var month = date.getUTCMonth();
          return token === 'M' ? String(month + 1) : addLeadingZeros(month + 1, 2);
        },
        // Day of the month
        d: function (date, token) {
          return addLeadingZeros(date.getUTCDate(), token.length);
        },
        // AM or PM
        a: function (date, token) {
          var dayPeriodEnumValue = date.getUTCHours() / 12 >= 1 ? 'pm' : 'am';

          switch (token) {
            case 'a':
            case 'aa':
              return dayPeriodEnumValue.toUpperCase();

            case 'aaa':
              return dayPeriodEnumValue;

            case 'aaaaa':
              return dayPeriodEnumValue[0];

            case 'aaaa':
            default:
              return dayPeriodEnumValue === 'am' ? 'a.m.' : 'p.m.';
          }
        },
        // Hour [1-12]
        h: function (date, token) {
          return addLeadingZeros(date.getUTCHours() % 12 || 12, token.length);
        },
        // Hour [0-23]
        H: function (date, token) {
          return addLeadingZeros(date.getUTCHours(), token.length);
        },
        // Minute
        m: function (date, token) {
          return addLeadingZeros(date.getUTCMinutes(), token.length);
        },
        // Second
        s: function (date, token) {
          return addLeadingZeros(date.getUTCSeconds(), token.length);
        },
        // Fraction of second
        S: function (date, token) {
          var numberOfDigits = token.length;
          var milliseconds = date.getUTCMilliseconds();
          var fractionalSeconds = Math.floor(milliseconds * Math.pow(10, numberOfDigits - 3));
          return addLeadingZeros(fractionalSeconds, token.length);
        }
      };

      var MILLISECONDS_IN_DAY = 86400000; // This function will be a part of public API when UTC function will be implemented.
// See issue: https://github.com/date-fns/date-fns/issues/376

      function getUTCDayOfYear(dirtyDate) {
        requiredArgs(1, arguments);
        var date = toDate(dirtyDate);
        var timestamp = date.getTime();
        date.setUTCMonth(0, 1);
        date.setUTCHours(0, 0, 0, 0);
        var startOfYearTimestamp = date.getTime();
        var difference = timestamp - startOfYearTimestamp;
        return Math.floor(difference / MILLISECONDS_IN_DAY) + 1;
      }

// See issue: https://github.com/date-fns/date-fns/issues/376

      function startOfUTCISOWeek(dirtyDate) {
        requiredArgs(1, arguments);
        var weekStartsOn = 1;
        var date = toDate(dirtyDate);
        var day = date.getUTCDay();
        var diff = (day < weekStartsOn ? 7 : 0) + day - weekStartsOn;
        date.setUTCDate(date.getUTCDate() - diff);
        date.setUTCHours(0, 0, 0, 0);
        return date;
      }

// See issue: https://github.com/date-fns/date-fns/issues/376

      function getUTCISOWeekYear(dirtyDate) {
        requiredArgs(1, arguments);
        var date = toDate(dirtyDate);
        var year = date.getUTCFullYear();
        var fourthOfJanuaryOfNextYear = new Date(0);
        fourthOfJanuaryOfNextYear.setUTCFullYear(year + 1, 0, 4);
        fourthOfJanuaryOfNextYear.setUTCHours(0, 0, 0, 0);
        var startOfNextYear = startOfUTCISOWeek(fourthOfJanuaryOfNextYear);
        var fourthOfJanuaryOfThisYear = new Date(0);
        fourthOfJanuaryOfThisYear.setUTCFullYear(year, 0, 4);
        fourthOfJanuaryOfThisYear.setUTCHours(0, 0, 0, 0);
        var startOfThisYear = startOfUTCISOWeek(fourthOfJanuaryOfThisYear);

        if (date.getTime() >= startOfNextYear.getTime()) {
          return year + 1;
        } else if (date.getTime() >= startOfThisYear.getTime()) {
          return year;
        } else {
          return year - 1;
        }
      }

// See issue: https://github.com/date-fns/date-fns/issues/376

      function startOfUTCISOWeekYear(dirtyDate) {
        requiredArgs(1, arguments);
        var year = getUTCISOWeekYear(dirtyDate);
        var fourthOfJanuary = new Date(0);
        fourthOfJanuary.setUTCFullYear(year, 0, 4);
        fourthOfJanuary.setUTCHours(0, 0, 0, 0);
        var date = startOfUTCISOWeek(fourthOfJanuary);
        return date;
      }

      var MILLISECONDS_IN_WEEK = 604800000; // This function will be a part of public API when UTC function will be implemented.
// See issue: https://github.com/date-fns/date-fns/issues/376

      function getUTCISOWeek(dirtyDate) {
        requiredArgs(1, arguments);
        var date = toDate(dirtyDate);
        var diff = startOfUTCISOWeek(date).getTime() - startOfUTCISOWeekYear(date).getTime(); // Round the number of days to the nearest integer
        // because the number of milliseconds in a week is not constant
        // (e.g. it's different in the week of the daylight saving time clock shift)

        return Math.round(diff / MILLISECONDS_IN_WEEK) + 1;
      }

// See issue: https://github.com/date-fns/date-fns/issues/376

      function startOfUTCWeek(dirtyDate, dirtyOptions) {
        requiredArgs(1, arguments);
        var options = dirtyOptions || {};
        var locale = options.locale;
        var localeWeekStartsOn = locale && locale.options && locale.options.weekStartsOn;
        var defaultWeekStartsOn = localeWeekStartsOn == null ? 0 : toInteger(localeWeekStartsOn);
        var weekStartsOn = options.weekStartsOn == null ? defaultWeekStartsOn : toInteger(options.weekStartsOn); // Test if weekStartsOn is between 0 and 6 _and_ is not NaN

        if (!(weekStartsOn >= 0 && weekStartsOn <= 6)) {
          throw new RangeError('weekStartsOn must be between 0 and 6 inclusively');
        }

        var date = toDate(dirtyDate);
        var day = date.getUTCDay();
        var diff = (day < weekStartsOn ? 7 : 0) + day - weekStartsOn;
        date.setUTCDate(date.getUTCDate() - diff);
        date.setUTCHours(0, 0, 0, 0);
        return date;
      }

// See issue: https://github.com/date-fns/date-fns/issues/376

      function getUTCWeekYear(dirtyDate, dirtyOptions) {
        requiredArgs(1, arguments);
        var date = toDate(dirtyDate, dirtyOptions);
        var year = date.getUTCFullYear();
        var options = dirtyOptions || {};
        var locale = options.locale;
        var localeFirstWeekContainsDate = locale && locale.options && locale.options.firstWeekContainsDate;
        var defaultFirstWeekContainsDate = localeFirstWeekContainsDate == null ? 1 : toInteger(localeFirstWeekContainsDate);
        var firstWeekContainsDate = options.firstWeekContainsDate == null ? defaultFirstWeekContainsDate : toInteger(options.firstWeekContainsDate); // Test if weekStartsOn is between 1 and 7 _and_ is not NaN

        if (!(firstWeekContainsDate >= 1 && firstWeekContainsDate <= 7)) {
          throw new RangeError('firstWeekContainsDate must be between 1 and 7 inclusively');
        }

        var firstWeekOfNextYear = new Date(0);
        firstWeekOfNextYear.setUTCFullYear(year + 1, 0, firstWeekContainsDate);
        firstWeekOfNextYear.setUTCHours(0, 0, 0, 0);
        var startOfNextYear = startOfUTCWeek(firstWeekOfNextYear, dirtyOptions);
        var firstWeekOfThisYear = new Date(0);
        firstWeekOfThisYear.setUTCFullYear(year, 0, firstWeekContainsDate);
        firstWeekOfThisYear.setUTCHours(0, 0, 0, 0);
        var startOfThisYear = startOfUTCWeek(firstWeekOfThisYear, dirtyOptions);

        if (date.getTime() >= startOfNextYear.getTime()) {
          return year + 1;
        } else if (date.getTime() >= startOfThisYear.getTime()) {
          return year;
        } else {
          return year - 1;
        }
      }

// See issue: https://github.com/date-fns/date-fns/issues/376

      function startOfUTCWeekYear(dirtyDate, dirtyOptions) {
        requiredArgs(1, arguments);
        var options = dirtyOptions || {};
        var locale = options.locale;
        var localeFirstWeekContainsDate = locale && locale.options && locale.options.firstWeekContainsDate;
        var defaultFirstWeekContainsDate = localeFirstWeekContainsDate == null ? 1 : toInteger(localeFirstWeekContainsDate);
        var firstWeekContainsDate = options.firstWeekContainsDate == null ? defaultFirstWeekContainsDate : toInteger(options.firstWeekContainsDate);
        var year = getUTCWeekYear(dirtyDate, dirtyOptions);
        var firstWeek = new Date(0);
        firstWeek.setUTCFullYear(year, 0, firstWeekContainsDate);
        firstWeek.setUTCHours(0, 0, 0, 0);
        var date = startOfUTCWeek(firstWeek, dirtyOptions);
        return date;
      }

      var MILLISECONDS_IN_WEEK$1 = 604800000; // This function will be a part of public API when UTC function will be implemented.
// See issue: https://github.com/date-fns/date-fns/issues/376

      function getUTCWeek(dirtyDate, options) {
        requiredArgs(1, arguments);
        var date = toDate(dirtyDate);
        var diff = startOfUTCWeek(date, options).getTime() - startOfUTCWeekYear(date, options).getTime(); // Round the number of days to the nearest integer
        // because the number of milliseconds in a week is not constant
        // (e.g. it's different in the week of the daylight saving time clock shift)

        return Math.round(diff / MILLISECONDS_IN_WEEK$1) + 1;
      }

      var dayPeriodEnum = {
        am: 'am',
        pm: 'pm',
        midnight: 'midnight',
        noon: 'noon',
        morning: 'morning',
        afternoon: 'afternoon',
        evening: 'evening',
        night: 'night'
        /*
   * |     | Unit                           |     | Unit                           |
   * |-----|--------------------------------|-----|--------------------------------|
   * |  a  | AM, PM                         |  A* | Milliseconds in day            |
   * |  b  | AM, PM, noon, midnight         |  B  | Flexible day period            |
   * |  c  | Stand-alone local day of week  |  C* | Localized hour w/ day period   |
   * |  d  | Day of month                   |  D  | Day of year                    |
   * |  e  | Local day of week              |  E  | Day of week                    |
   * |  f  |                                |  F* | Day of week in month           |
   * |  g* | Modified Julian day            |  G  | Era                            |
   * |  h  | Hour [1-12]                    |  H  | Hour [0-23]                    |
   * |  i! | ISO day of week                |  I! | ISO week of year               |
   * |  j* | Localized hour w/ day period   |  J* | Localized hour w/o day period  |
   * |  k  | Hour [1-24]                    |  K  | Hour [0-11]                    |
   * |  l* | (deprecated)                   |  L  | Stand-alone month              |
   * |  m  | Minute                         |  M  | Month                          |
   * |  n  |                                |  N  |                                |
   * |  o! | Ordinal number modifier        |  O  | Timezone (GMT)                 |
   * |  p! | Long localized time            |  P! | Long localized date            |
   * |  q  | Stand-alone quarter            |  Q  | Quarter                        |
   * |  r* | Related Gregorian year         |  R! | ISO week-numbering year        |
   * |  s  | Second                         |  S  | Fraction of second             |
   * |  t! | Seconds timestamp              |  T! | Milliseconds timestamp         |
   * |  u  | Extended year                  |  U* | Cyclic year                    |
   * |  v* | Timezone (generic non-locat.)  |  V* | Timezone (location)            |
   * |  w  | Local week of year             |  W* | Week of month                  |
   * |  x  | Timezone (ISO-8601 w/o Z)      |  X  | Timezone (ISO-8601)            |
   * |  y  | Year (abs)                     |  Y  | Local week-numbering year      |
   * |  z  | Timezone (specific non-locat.) |  Z* | Timezone (aliases)             |
   *
   * Letters marked by * are not implemented but reserved by Unicode standard.
   *
   * Letters marked by ! are non-standard, but implemented by date-fns:
   * - `o` modifies the previous token to turn it into an ordinal (see `format` docs)
   * - `i` is ISO day of week. For `i` and `ii` is returns numeric ISO week days,
   *   i.e. 7 for Sunday, 1 for Monday, etc.
   * - `I` is ISO week of year, as opposed to `w` which is local week of year.
   * - `R` is ISO week-numbering year, as opposed to `Y` which is local week-numbering year.
   *   `R` is supposed to be used in conjunction with `I` and `i`
   *   for universal ISO week-numbering date, whereas
   *   `Y` is supposed to be used in conjunction with `w` and `e`
   *   for week-numbering date specific to the locale.
   * - `P` is long localized date format
   * - `p` is long localized time format
   */

      };
      var formatters$1 = {
        // Era
        G: function (date, token, localize) {
          var era = date.getUTCFullYear() > 0 ? 1 : 0;

          switch (token) {
              // AD, BC
            case 'G':
            case 'GG':
            case 'GGG':
              return localize.era(era, {
                width: 'abbreviated'
              });
              // A, B

            case 'GGGGG':
              return localize.era(era, {
                width: 'narrow'
              });
              // Anno Domini, Before Christ

            case 'GGGG':
            default:
              return localize.era(era, {
                width: 'wide'
              });
          }
        },
        // Year
        y: function (date, token, localize) {
          // Ordinal number
          if (token === 'yo') {
            var signedYear = date.getUTCFullYear(); // Returns 1 for 1 BC (which is year 0 in JavaScript)

            var year = signedYear > 0 ? signedYear : 1 - signedYear;
            return localize.ordinalNumber(year, {
              unit: 'year'
            });
          }

          return formatters.y(date, token);
        },
        // Local week-numbering year
        Y: function (date, token, localize, options) {
          var signedWeekYear = getUTCWeekYear(date, options); // Returns 1 for 1 BC (which is year 0 in JavaScript)

          var weekYear = signedWeekYear > 0 ? signedWeekYear : 1 - signedWeekYear; // Two digit year

          if (token === 'YY') {
            var twoDigitYear = weekYear % 100;
            return addLeadingZeros(twoDigitYear, 2);
          } // Ordinal number


          if (token === 'Yo') {
            return localize.ordinalNumber(weekYear, {
              unit: 'year'
            });
          } // Padding


          return addLeadingZeros(weekYear, token.length);
        },
        // ISO week-numbering year
        R: function (date, token) {
          var isoWeekYear = getUTCISOWeekYear(date); // Padding

          return addLeadingZeros(isoWeekYear, token.length);
        },
        // Extended year. This is a single number designating the year of this calendar system.
        // The main difference between `y` and `u` localizers are B.C. years:
        // | Year | `y` | `u` |
        // |------|-----|-----|
        // | AC 1 |   1 |   1 |
        // | BC 1 |   1 |   0 |
        // | BC 2 |   2 |  -1 |
        // Also `yy` always returns the last two digits of a year,
        // while `uu` pads single digit years to 2 characters and returns other years unchanged.
        u: function (date, token) {
          var year = date.getUTCFullYear();
          return addLeadingZeros(year, token.length);
        },
        // Quarter
        Q: function (date, token, localize) {
          var quarter = Math.ceil((date.getUTCMonth() + 1) / 3);

          switch (token) {
              // 1, 2, 3, 4
            case 'Q':
              return String(quarter);
              // 01, 02, 03, 04

            case 'QQ':
              return addLeadingZeros(quarter, 2);
              // 1st, 2nd, 3rd, 4th

            case 'Qo':
              return localize.ordinalNumber(quarter, {
                unit: 'quarter'
              });
              // Q1, Q2, Q3, Q4

            case 'QQQ':
              return localize.quarter(quarter, {
                width: 'abbreviated',
                context: 'formatting'
              });
              // 1, 2, 3, 4 (narrow quarter; could be not numerical)

            case 'QQQQQ':
              return localize.quarter(quarter, {
                width: 'narrow',
                context: 'formatting'
              });
              // 1st quarter, 2nd quarter, ...

            case 'QQQQ':
            default:
              return localize.quarter(quarter, {
                width: 'wide',
                context: 'formatting'
              });
          }
        },
        // Stand-alone quarter
        q: function (date, token, localize) {
          var quarter = Math.ceil((date.getUTCMonth() + 1) / 3);

          switch (token) {
              // 1, 2, 3, 4
            case 'q':
              return String(quarter);
              // 01, 02, 03, 04

            case 'qq':
              return addLeadingZeros(quarter, 2);
              // 1st, 2nd, 3rd, 4th

            case 'qo':
              return localize.ordinalNumber(quarter, {
                unit: 'quarter'
              });
              // Q1, Q2, Q3, Q4

            case 'qqq':
              return localize.quarter(quarter, {
                width: 'abbreviated',
                context: 'standalone'
              });
              // 1, 2, 3, 4 (narrow quarter; could be not numerical)

            case 'qqqqq':
              return localize.quarter(quarter, {
                width: 'narrow',
                context: 'standalone'
              });
              // 1st quarter, 2nd quarter, ...

            case 'qqqq':
            default:
              return localize.quarter(quarter, {
                width: 'wide',
                context: 'standalone'
              });
          }
        },
        // Month
        M: function (date, token, localize) {
          var month = date.getUTCMonth();

          switch (token) {
            case 'M':
            case 'MM':
              return formatters.M(date, token);
              // 1st, 2nd, ..., 12th

            case 'Mo':
              return localize.ordinalNumber(month + 1, {
                unit: 'month'
              });
              // Jan, Feb, ..., Dec

            case 'MMM':
              return localize.month(month, {
                width: 'abbreviated',
                context: 'formatting'
              });
              // J, F, ..., D

            case 'MMMMM':
              return localize.month(month, {
                width: 'narrow',
                context: 'formatting'
              });
              // January, February, ..., December

            case 'MMMM':
            default:
              return localize.month(month, {
                width: 'wide',
                context: 'formatting'
              });
          }
        },
        // Stand-alone month
        L: function (date, token, localize) {
          var month = date.getUTCMonth();

          switch (token) {
              // 1, 2, ..., 12
            case 'L':
              return String(month + 1);
              // 01, 02, ..., 12

            case 'LL':
              return addLeadingZeros(month + 1, 2);
              // 1st, 2nd, ..., 12th

            case 'Lo':
              return localize.ordinalNumber(month + 1, {
                unit: 'month'
              });
              // Jan, Feb, ..., Dec

            case 'LLL':
              return localize.month(month, {
                width: 'abbreviated',
                context: 'standalone'
              });
              // J, F, ..., D

            case 'LLLLL':
              return localize.month(month, {
                width: 'narrow',
                context: 'standalone'
              });
              // January, February, ..., December

            case 'LLLL':
            default:
              return localize.month(month, {
                width: 'wide',
                context: 'standalone'
              });
          }
        },
        // Local week of year
        w: function (date, token, localize, options) {
          var week = getUTCWeek(date, options);

          if (token === 'wo') {
            return localize.ordinalNumber(week, {
              unit: 'week'
            });
          }

          return addLeadingZeros(week, token.length);
        },
        // ISO week of year
        I: function (date, token, localize) {
          var isoWeek = getUTCISOWeek(date);

          if (token === 'Io') {
            return localize.ordinalNumber(isoWeek, {
              unit: 'week'
            });
          }

          return addLeadingZeros(isoWeek, token.length);
        },
        // Day of the month
        d: function (date, token, localize) {
          if (token === 'do') {
            return localize.ordinalNumber(date.getUTCDate(), {
              unit: 'date'
            });
          }

          return formatters.d(date, token);
        },
        // Day of year
        D: function (date, token, localize) {
          var dayOfYear = getUTCDayOfYear(date);

          if (token === 'Do') {
            return localize.ordinalNumber(dayOfYear, {
              unit: 'dayOfYear'
            });
          }

          return addLeadingZeros(dayOfYear, token.length);
        },
        // Day of week
        E: function (date, token, localize) {
          var dayOfWeek = date.getUTCDay();

          switch (token) {
              // Tue
            case 'E':
            case 'EE':
            case 'EEE':
              return localize.day(dayOfWeek, {
                width: 'abbreviated',
                context: 'formatting'
              });
              // T

            case 'EEEEE':
              return localize.day(dayOfWeek, {
                width: 'narrow',
                context: 'formatting'
              });
              // Tu

            case 'EEEEEE':
              return localize.day(dayOfWeek, {
                width: 'short',
                context: 'formatting'
              });
              // Tuesday

            case 'EEEE':
            default:
              return localize.day(dayOfWeek, {
                width: 'wide',
                context: 'formatting'
              });
          }
        },
        // Local day of week
        e: function (date, token, localize, options) {
          var dayOfWeek = date.getUTCDay();
          var localDayOfWeek = (dayOfWeek - options.weekStartsOn + 8) % 7 || 7;

          switch (token) {
              // Numerical value (Nth day of week with current locale or weekStartsOn)
            case 'e':
              return String(localDayOfWeek);
              // Padded numerical value

            case 'ee':
              return addLeadingZeros(localDayOfWeek, 2);
              // 1st, 2nd, ..., 7th

            case 'eo':
              return localize.ordinalNumber(localDayOfWeek, {
                unit: 'day'
              });

            case 'eee':
              return localize.day(dayOfWeek, {
                width: 'abbreviated',
                context: 'formatting'
              });
              // T

            case 'eeeee':
              return localize.day(dayOfWeek, {
                width: 'narrow',
                context: 'formatting'
              });
              // Tu

            case 'eeeeee':
              return localize.day(dayOfWeek, {
                width: 'short',
                context: 'formatting'
              });
              // Tuesday

            case 'eeee':
            default:
              return localize.day(dayOfWeek, {
                width: 'wide',
                context: 'formatting'
              });
          }
        },
        // Stand-alone local day of week
        c: function (date, token, localize, options) {
          var dayOfWeek = date.getUTCDay();
          var localDayOfWeek = (dayOfWeek - options.weekStartsOn + 8) % 7 || 7;

          switch (token) {
              // Numerical value (same as in `e`)
            case 'c':
              return String(localDayOfWeek);
              // Padded numerical value

            case 'cc':
              return addLeadingZeros(localDayOfWeek, token.length);
              // 1st, 2nd, ..., 7th

            case 'co':
              return localize.ordinalNumber(localDayOfWeek, {
                unit: 'day'
              });

            case 'ccc':
              return localize.day(dayOfWeek, {
                width: 'abbreviated',
                context: 'standalone'
              });
              // T

            case 'ccccc':
              return localize.day(dayOfWeek, {
                width: 'narrow',
                context: 'standalone'
              });
              // Tu

            case 'cccccc':
              return localize.day(dayOfWeek, {
                width: 'short',
                context: 'standalone'
              });
              // Tuesday

            case 'cccc':
            default:
              return localize.day(dayOfWeek, {
                width: 'wide',
                context: 'standalone'
              });
          }
        },
        // ISO day of week
        i: function (date, token, localize) {
          var dayOfWeek = date.getUTCDay();
          var isoDayOfWeek = dayOfWeek === 0 ? 7 : dayOfWeek;

          switch (token) {
              // 2
            case 'i':
              return String(isoDayOfWeek);
              // 02

            case 'ii':
              return addLeadingZeros(isoDayOfWeek, token.length);
              // 2nd

            case 'io':
              return localize.ordinalNumber(isoDayOfWeek, {
                unit: 'day'
              });
              // Tue

            case 'iii':
              return localize.day(dayOfWeek, {
                width: 'abbreviated',
                context: 'formatting'
              });
              // T

            case 'iiiii':
              return localize.day(dayOfWeek, {
                width: 'narrow',
                context: 'formatting'
              });
              // Tu

            case 'iiiiii':
              return localize.day(dayOfWeek, {
                width: 'short',
                context: 'formatting'
              });
              // Tuesday

            case 'iiii':
            default:
              return localize.day(dayOfWeek, {
                width: 'wide',
                context: 'formatting'
              });
          }
        },
        // AM or PM
        a: function (date, token, localize) {
          var hours = date.getUTCHours();
          var dayPeriodEnumValue = hours / 12 >= 1 ? 'pm' : 'am';

          switch (token) {
            case 'a':
            case 'aa':
              return localize.dayPeriod(dayPeriodEnumValue, {
                width: 'abbreviated',
                context: 'formatting'
              });

            case 'aaa':
              return localize.dayPeriod(dayPeriodEnumValue, {
                width: 'abbreviated',
                context: 'formatting'
              }).toLowerCase();

            case 'aaaaa':
              return localize.dayPeriod(dayPeriodEnumValue, {
                width: 'narrow',
                context: 'formatting'
              });

            case 'aaaa':
            default:
              return localize.dayPeriod(dayPeriodEnumValue, {
                width: 'wide',
                context: 'formatting'
              });
          }
        },
        // AM, PM, midnight, noon
        b: function (date, token, localize) {
          var hours = date.getUTCHours();
          var dayPeriodEnumValue;

          if (hours === 12) {
            dayPeriodEnumValue = dayPeriodEnum.noon;
          } else if (hours === 0) {
            dayPeriodEnumValue = dayPeriodEnum.midnight;
          } else {
            dayPeriodEnumValue = hours / 12 >= 1 ? 'pm' : 'am';
          }

          switch (token) {
            case 'b':
            case 'bb':
              return localize.dayPeriod(dayPeriodEnumValue, {
                width: 'abbreviated',
                context: 'formatting'
              });

            case 'bbb':
              return localize.dayPeriod(dayPeriodEnumValue, {
                width: 'abbreviated',
                context: 'formatting'
              }).toLowerCase();

            case 'bbbbb':
              return localize.dayPeriod(dayPeriodEnumValue, {
                width: 'narrow',
                context: 'formatting'
              });

            case 'bbbb':
            default:
              return localize.dayPeriod(dayPeriodEnumValue, {
                width: 'wide',
                context: 'formatting'
              });
          }
        },
        // in the morning, in the afternoon, in the evening, at night
        B: function (date, token, localize) {
          var hours = date.getUTCHours();
          var dayPeriodEnumValue;

          if (hours >= 17) {
            dayPeriodEnumValue = dayPeriodEnum.evening;
          } else if (hours >= 12) {
            dayPeriodEnumValue = dayPeriodEnum.afternoon;
          } else if (hours >= 4) {
            dayPeriodEnumValue = dayPeriodEnum.morning;
          } else {
            dayPeriodEnumValue = dayPeriodEnum.night;
          }

          switch (token) {
            case 'B':
            case 'BB':
            case 'BBB':
              return localize.dayPeriod(dayPeriodEnumValue, {
                width: 'abbreviated',
                context: 'formatting'
              });

            case 'BBBBB':
              return localize.dayPeriod(dayPeriodEnumValue, {
                width: 'narrow',
                context: 'formatting'
              });

            case 'BBBB':
            default:
              return localize.dayPeriod(dayPeriodEnumValue, {
                width: 'wide',
                context: 'formatting'
              });
          }
        },
        // Hour [1-12]
        h: function (date, token, localize) {
          if (token === 'ho') {
            var hours = date.getUTCHours() % 12;
            if (hours === 0) hours = 12;
            return localize.ordinalNumber(hours, {
              unit: 'hour'
            });
          }

          return formatters.h(date, token);
        },
        // Hour [0-23]
        H: function (date, token, localize) {
          if (token === 'Ho') {
            return localize.ordinalNumber(date.getUTCHours(), {
              unit: 'hour'
            });
          }

          return formatters.H(date, token);
        },
        // Hour [0-11]
        K: function (date, token, localize) {
          var hours = date.getUTCHours() % 12;

          if (token === 'Ko') {
            return localize.ordinalNumber(hours, {
              unit: 'hour'
            });
          }

          return addLeadingZeros(hours, token.length);
        },
        // Hour [1-24]
        k: function (date, token, localize) {
          var hours = date.getUTCHours();
          if (hours === 0) hours = 24;

          if (token === 'ko') {
            return localize.ordinalNumber(hours, {
              unit: 'hour'
            });
          }

          return addLeadingZeros(hours, token.length);
        },
        // Minute
        m: function (date, token, localize) {
          if (token === 'mo') {
            return localize.ordinalNumber(date.getUTCMinutes(), {
              unit: 'minute'
            });
          }

          return formatters.m(date, token);
        },
        // Second
        s: function (date, token, localize) {
          if (token === 'so') {
            return localize.ordinalNumber(date.getUTCSeconds(), {
              unit: 'second'
            });
          }

          return formatters.s(date, token);
        },
        // Fraction of second
        S: function (date, token) {
          return formatters.S(date, token);
        },
        // Timezone (ISO-8601. If offset is 0, output is always `'Z'`)
        X: function (date, token, _localize, options) {
          var originalDate = options._originalDate || date;
          var timezoneOffset = originalDate.getTimezoneOffset();

          if (timezoneOffset === 0) {
            return 'Z';
          }

          switch (token) {
              // Hours and optional minutes
            case 'X':
              return formatTimezoneWithOptionalMinutes(timezoneOffset);
              // Hours, minutes and optional seconds without `:` delimiter
              // Note: neither ISO-8601 nor JavaScript supports seconds in timezone offsets
              // so this token always has the same output as `XX`

            case 'XXXX':
            case 'XX':
              // Hours and minutes without `:` delimiter
              return formatTimezone(timezoneOffset);
              // Hours, minutes and optional seconds with `:` delimiter
              // Note: neither ISO-8601 nor JavaScript supports seconds in timezone offsets
              // so this token always has the same output as `XXX`

            case 'XXXXX':
            case 'XXX': // Hours and minutes with `:` delimiter

            default:
              return formatTimezone(timezoneOffset, ':');
          }
        },
        // Timezone (ISO-8601. If offset is 0, output is `'+00:00'` or equivalent)
        x: function (date, token, _localize, options) {
          var originalDate = options._originalDate || date;
          var timezoneOffset = originalDate.getTimezoneOffset();

          switch (token) {
              // Hours and optional minutes
            case 'x':
              return formatTimezoneWithOptionalMinutes(timezoneOffset);
              // Hours, minutes and optional seconds without `:` delimiter
              // Note: neither ISO-8601 nor JavaScript supports seconds in timezone offsets
              // so this token always has the same output as `xx`

            case 'xxxx':
            case 'xx':
              // Hours and minutes without `:` delimiter
              return formatTimezone(timezoneOffset);
              // Hours, minutes and optional seconds with `:` delimiter
              // Note: neither ISO-8601 nor JavaScript supports seconds in timezone offsets
              // so this token always has the same output as `xxx`

            case 'xxxxx':
            case 'xxx': // Hours and minutes with `:` delimiter

            default:
              return formatTimezone(timezoneOffset, ':');
          }
        },
        // Timezone (GMT)
        O: function (date, token, _localize, options) {
          var originalDate = options._originalDate || date;
          var timezoneOffset = originalDate.getTimezoneOffset();

          switch (token) {
              // Short
            case 'O':
            case 'OO':
            case 'OOO':
              return 'GMT' + formatTimezoneShort(timezoneOffset, ':');
              // Long

            case 'OOOO':
            default:
              return 'GMT' + formatTimezone(timezoneOffset, ':');
          }
        },
        // Timezone (specific non-location)
        z: function (date, token, _localize, options) {
          var originalDate = options._originalDate || date;
          var timezoneOffset = originalDate.getTimezoneOffset();

          switch (token) {
              // Short
            case 'z':
            case 'zz':
            case 'zzz':
              return 'GMT' + formatTimezoneShort(timezoneOffset, ':');
              // Long

            case 'zzzz':
            default:
              return 'GMT' + formatTimezone(timezoneOffset, ':');
          }
        },
        // Seconds timestamp
        t: function (date, token, _localize, options) {
          var originalDate = options._originalDate || date;
          var timestamp = Math.floor(originalDate.getTime() / 1000);
          return addLeadingZeros(timestamp, token.length);
        },
        // Milliseconds timestamp
        T: function (date, token, _localize, options) {
          var originalDate = options._originalDate || date;
          var timestamp = originalDate.getTime();
          return addLeadingZeros(timestamp, token.length);
        }
      };

      function formatTimezoneShort(offset, dirtyDelimiter) {
        var sign = offset > 0 ? '-' : '+';
        var absOffset = Math.abs(offset);
        var hours = Math.floor(absOffset / 60);
        var minutes = absOffset % 60;

        if (minutes === 0) {
          return sign + String(hours);
        }

        var delimiter = dirtyDelimiter || '';
        return sign + String(hours) + delimiter + addLeadingZeros(minutes, 2);
      }

      function formatTimezoneWithOptionalMinutes(offset, dirtyDelimiter) {
        if (offset % 60 === 0) {
          var sign = offset > 0 ? '-' : '+';
          return sign + addLeadingZeros(Math.abs(offset) / 60, 2);
        }

        return formatTimezone(offset, dirtyDelimiter);
      }

      function formatTimezone(offset, dirtyDelimiter) {
        var delimiter = dirtyDelimiter || '';
        var sign = offset > 0 ? '-' : '+';
        var absOffset = Math.abs(offset);
        var hours = addLeadingZeros(Math.floor(absOffset / 60), 2);
        var minutes = addLeadingZeros(absOffset % 60, 2);
        return sign + hours + delimiter + minutes;
      }

      function dateLongFormatter(pattern, formatLong) {
        switch (pattern) {
          case 'P':
            return formatLong.date({
              width: 'short'
            });

          case 'PP':
            return formatLong.date({
              width: 'medium'
            });

          case 'PPP':
            return formatLong.date({
              width: 'long'
            });

          case 'PPPP':
          default:
            return formatLong.date({
              width: 'full'
            });
        }
      }

      function timeLongFormatter(pattern, formatLong) {
        switch (pattern) {
          case 'p':
            return formatLong.time({
              width: 'short'
            });

          case 'pp':
            return formatLong.time({
              width: 'medium'
            });

          case 'ppp':
            return formatLong.time({
              width: 'long'
            });

          case 'pppp':
          default:
            return formatLong.time({
              width: 'full'
            });
        }
      }

      function dateTimeLongFormatter(pattern, formatLong) {
        var matchResult = pattern.match(/(P+)(p+)?/);
        var datePattern = matchResult[1];
        var timePattern = matchResult[2];

        if (!timePattern) {
          return dateLongFormatter(pattern, formatLong);
        }

        var dateTimeFormat;

        switch (datePattern) {
          case 'P':
            dateTimeFormat = formatLong.dateTime({
              width: 'short'
            });
            break;

          case 'PP':
            dateTimeFormat = formatLong.dateTime({
              width: 'medium'
            });
            break;

          case 'PPP':
            dateTimeFormat = formatLong.dateTime({
              width: 'long'
            });
            break;

          case 'PPPP':
          default:
            dateTimeFormat = formatLong.dateTime({
              width: 'full'
            });
            break;
        }

        return dateTimeFormat.replace('{{date}}', dateLongFormatter(datePattern, formatLong)).replace('{{time}}', timeLongFormatter(timePattern, formatLong));
      }

      var longFormatters = {
        p: timeLongFormatter,
        P: dateTimeLongFormatter
      };

      var protectedDayOfYearTokens = ['D', 'DD'];
      var protectedWeekYearTokens = ['YY', 'YYYY'];
      function isProtectedDayOfYearToken(token) {
        return protectedDayOfYearTokens.indexOf(token) !== -1;
      }
      function isProtectedWeekYearToken(token) {
        return protectedWeekYearTokens.indexOf(token) !== -1;
      }
      function throwProtectedError(token, format, input) {
        if (token === 'YYYY') {
          throw new RangeError("Use `yyyy` instead of `YYYY` (in `".concat(format, "`) for formatting years to the input `").concat(input, "`; see: https://git.io/fxCyr"));
        } else if (token === 'YY') {
          throw new RangeError("Use `yy` instead of `YY` (in `".concat(format, "`) for formatting years to the input `").concat(input, "`; see: https://git.io/fxCyr"));
        } else if (token === 'D') {
          throw new RangeError("Use `d` instead of `D` (in `".concat(format, "`) for formatting days of the month to the input `").concat(input, "`; see: https://git.io/fxCyr"));
        } else if (token === 'DD') {
          throw new RangeError("Use `dd` instead of `DD` (in `".concat(format, "`) for formatting days of the month to the input `").concat(input, "`; see: https://git.io/fxCyr"));
        }
      }

// - [yYQqMLwIdDecihHKkms]o matches any available ordinal number token
//   (one of the certain letters followed by `o`)
// - (\w)\1* matches any sequences of the same letter
// - '' matches two quote characters in a row
// - '(''|[^'])+('|$) matches anything surrounded by two quote characters ('),
//   except a single quote symbol, which ends the sequence.
//   Two quote characters do not end the sequence.
//   If there is no matching single quote
//   then the sequence will continue until the end of the string.
// - . matches any single character unmatched by previous parts of the RegExps

      var formattingTokensRegExp = /[yYQqMLwIdDecihHKkms]o|(\w)\1*|''|'(''|[^'])+('|$)|./g; // This RegExp catches symbols escaped by quotes, and also
// sequences of symbols P, p, and the combinations like `PPPPPPPppppp`

      var longFormattingTokensRegExp = /P+p+|P+|p+|''|'(''|[^'])+('|$)|./g;
      var escapedStringRegExp = /^'([^]*?)'?$/;
      var doubleQuoteRegExp = /''/g;
      var unescapedLatinCharacterRegExp = /[a-zA-Z]/;
      /**
       * @name format
       * @category Common Helpers
       * @summary Format the date.
       *
       * @description
       * Return the formatted date string in the given format. The result may vary by locale.
       *
       * > ⚠️ Please note that the `format` tokens differ from Moment.js and other libraries.
       * > See: https://git.io/fxCyr
       *
       * The characters wrapped between two single quotes characters (') are escaped.
       * Two single quotes in a row, whether inside or outside a quoted sequence, represent a 'real' single quote.
       * (see the last example)
       *
       * Format of the string is based on Unicode Technical Standard #35:
       * https://www.unicode.org/reports/tr35/tr35-dates.html#Date_Field_Symbol_Table
       * with a few additions (see note 7 below the table).
       *
       * Accepted patterns:
       * | Unit                            | Pattern | Result examples                   | Notes |
       * |---------------------------------|---------|-----------------------------------|-------|
       * | Era                             | G..GGG  | AD, BC                            |       |
       * |                                 | GGGG    | Anno Domini, Before Christ        | 2     |
       * |                                 | GGGGG   | A, B                              |       |
       * | Calendar year                   | y       | 44, 1, 1900, 2017                 | 5     |
       * |                                 | yo      | 44th, 1st, 0th, 17th              | 5,7   |
       * |                                 | yy      | 44, 01, 00, 17                    | 5     |
       * |                                 | yyy     | 044, 001, 1900, 2017              | 5     |
       * |                                 | yyyy    | 0044, 0001, 1900, 2017            | 5     |
       * |                                 | yyyyy   | ...                               | 3,5   |
       * | Local week-numbering year       | Y       | 44, 1, 1900, 2017                 | 5     |
       * |                                 | Yo      | 44th, 1st, 1900th, 2017th         | 5,7   |
       * |                                 | YY      | 44, 01, 00, 17                    | 5,8   |
       * |                                 | YYY     | 044, 001, 1900, 2017              | 5     |
       * |                                 | YYYY    | 0044, 0001, 1900, 2017            | 5,8   |
       * |                                 | YYYYY   | ...                               | 3,5   |
       * | ISO week-numbering year         | R       | -43, 0, 1, 1900, 2017             | 5,7   |
       * |                                 | RR      | -43, 00, 01, 1900, 2017           | 5,7   |
       * |                                 | RRR     | -043, 000, 001, 1900, 2017        | 5,7   |
       * |                                 | RRRR    | -0043, 0000, 0001, 1900, 2017     | 5,7   |
       * |                                 | RRRRR   | ...                               | 3,5,7 |
       * | Extended year                   | u       | -43, 0, 1, 1900, 2017             | 5     |
       * |                                 | uu      | -43, 01, 1900, 2017               | 5     |
       * |                                 | uuu     | -043, 001, 1900, 2017             | 5     |
       * |                                 | uuuu    | -0043, 0001, 1900, 2017           | 5     |
       * |                                 | uuuuu   | ...                               | 3,5   |
       * | Quarter (formatting)            | Q       | 1, 2, 3, 4                        |       |
       * |                                 | Qo      | 1st, 2nd, 3rd, 4th                | 7     |
       * |                                 | QQ      | 01, 02, 03, 04                    |       |
       * |                                 | QQQ     | Q1, Q2, Q3, Q4                    |       |
       * |                                 | QQQQ    | 1st quarter, 2nd quarter, ...     | 2     |
       * |                                 | QQQQQ   | 1, 2, 3, 4                        | 4     |
       * | Quarter (stand-alone)           | q       | 1, 2, 3, 4                        |       |
       * |                                 | qo      | 1st, 2nd, 3rd, 4th                | 7     |
       * |                                 | qq      | 01, 02, 03, 04                    |       |
       * |                                 | qqq     | Q1, Q2, Q3, Q4                    |       |
       * |                                 | qqqq    | 1st quarter, 2nd quarter, ...     | 2     |
       * |                                 | qqqqq   | 1, 2, 3, 4                        | 4     |
       * | Month (formatting)              | M       | 1, 2, ..., 12                     |       |
       * |                                 | Mo      | 1st, 2nd, ..., 12th               | 7     |
       * |                                 | MM      | 01, 02, ..., 12                   |       |
       * |                                 | MMM     | Jan, Feb, ..., Dec                |       |
       * |                                 | MMMM    | January, February, ..., December  | 2     |
       * |                                 | MMMMM   | J, F, ..., D                      |       |
       * | Month (stand-alone)             | L       | 1, 2, ..., 12                     |       |
       * |                                 | Lo      | 1st, 2nd, ..., 12th               | 7     |
       * |                                 | LL      | 01, 02, ..., 12                   |       |
       * |                                 | LLL     | Jan, Feb, ..., Dec                |       |
       * |                                 | LLLL    | January, February, ..., December  | 2     |
       * |                                 | LLLLL   | J, F, ..., D                      |       |
       * | Local week of year              | w       | 1, 2, ..., 53                     |       |
       * |                                 | wo      | 1st, 2nd, ..., 53th               | 7     |
       * |                                 | ww      | 01, 02, ..., 53                   |       |
       * | ISO week of year                | I       | 1, 2, ..., 53                     | 7     |
       * |                                 | Io      | 1st, 2nd, ..., 53th               | 7     |
       * |                                 | II      | 01, 02, ..., 53                   | 7     |
       * | Day of month                    | d       | 1, 2, ..., 31                     |       |
       * |                                 | do      | 1st, 2nd, ..., 31st               | 7     |
       * |                                 | dd      | 01, 02, ..., 31                   |       |
       * | Day of year                     | D       | 1, 2, ..., 365, 366               | 9     |
       * |                                 | Do      | 1st, 2nd, ..., 365th, 366th       | 7     |
       * |                                 | DD      | 01, 02, ..., 365, 366             | 9     |
       * |                                 | DDD     | 001, 002, ..., 365, 366           |       |
       * |                                 | DDDD    | ...                               | 3     |
       * | Day of week (formatting)        | E..EEE  | Mon, Tue, Wed, ..., Sun           |       |
       * |                                 | EEEE    | Monday, Tuesday, ..., Sunday      | 2     |
       * |                                 | EEEEE   | M, T, W, T, F, S, S               |       |
       * |                                 | EEEEEE  | Mo, Tu, We, Th, Fr, Su, Sa        |       |
       * | ISO day of week (formatting)    | i       | 1, 2, 3, ..., 7                   | 7     |
       * |                                 | io      | 1st, 2nd, ..., 7th                | 7     |
       * |                                 | ii      | 01, 02, ..., 07                   | 7     |
       * |                                 | iii     | Mon, Tue, Wed, ..., Sun           | 7     |
       * |                                 | iiii    | Monday, Tuesday, ..., Sunday      | 2,7   |
       * |                                 | iiiii   | M, T, W, T, F, S, S               | 7     |
       * |                                 | iiiiii  | Mo, Tu, We, Th, Fr, Su, Sa        | 7     |
       * | Local day of week (formatting)  | e       | 2, 3, 4, ..., 1                   |       |
       * |                                 | eo      | 2nd, 3rd, ..., 1st                | 7     |
       * |                                 | ee      | 02, 03, ..., 01                   |       |
       * |                                 | eee     | Mon, Tue, Wed, ..., Sun           |       |
       * |                                 | eeee    | Monday, Tuesday, ..., Sunday      | 2     |
       * |                                 | eeeee   | M, T, W, T, F, S, S               |       |
       * |                                 | eeeeee  | Mo, Tu, We, Th, Fr, Su, Sa        |       |
       * | Local day of week (stand-alone) | c       | 2, 3, 4, ..., 1                   |       |
       * |                                 | co      | 2nd, 3rd, ..., 1st                | 7     |
       * |                                 | cc      | 02, 03, ..., 01                   |       |
       * |                                 | ccc     | Mon, Tue, Wed, ..., Sun           |       |
       * |                                 | cccc    | Monday, Tuesday, ..., Sunday      | 2     |
       * |                                 | ccccc   | M, T, W, T, F, S, S               |       |
       * |                                 | cccccc  | Mo, Tu, We, Th, Fr, Su, Sa        |       |
       * | AM, PM                          | a..aa   | AM, PM                            |       |
       * |                                 | aaa     | am, pm                            |       |
       * |                                 | aaaa    | a.m., p.m.                        | 2     |
       * |                                 | aaaaa   | a, p                              |       |
       * | AM, PM, noon, midnight          | b..bb   | AM, PM, noon, midnight            |       |
       * |                                 | bbb     | am, pm, noon, midnight            |       |
       * |                                 | bbbb    | a.m., p.m., noon, midnight        | 2     |
       * |                                 | bbbbb   | a, p, n, mi                       |       |
       * | Flexible day period             | B..BBB  | at night, in the morning, ...     |       |
       * |                                 | BBBB    | at night, in the morning, ...     | 2     |
       * |                                 | BBBBB   | at night, in the morning, ...     |       |
       * | Hour [1-12]                     | h       | 1, 2, ..., 11, 12                 |       |
       * |                                 | ho      | 1st, 2nd, ..., 11th, 12th         | 7     |
       * |                                 | hh      | 01, 02, ..., 11, 12               |       |
       * | Hour [0-23]                     | H       | 0, 1, 2, ..., 23                  |       |
       * |                                 | Ho      | 0th, 1st, 2nd, ..., 23rd          | 7     |
       * |                                 | HH      | 00, 01, 02, ..., 23               |       |
       * | Hour [0-11]                     | K       | 1, 2, ..., 11, 0                  |       |
       * |                                 | Ko      | 1st, 2nd, ..., 11th, 0th          | 7     |
       * |                                 | KK      | 01, 02, ..., 11, 00               |       |
       * | Hour [1-24]                     | k       | 24, 1, 2, ..., 23                 |       |
       * |                                 | ko      | 24th, 1st, 2nd, ..., 23rd         | 7     |
       * |                                 | kk      | 24, 01, 02, ..., 23               |       |
       * | Minute                          | m       | 0, 1, ..., 59                     |       |
       * |                                 | mo      | 0th, 1st, ..., 59th               | 7     |
       * |                                 | mm      | 00, 01, ..., 59                   |       |
       * | Second                          | s       | 0, 1, ..., 59                     |       |
       * |                                 | so      | 0th, 1st, ..., 59th               | 7     |
       * |                                 | ss      | 00, 01, ..., 59                   |       |
       * | Fraction of second              | S       | 0, 1, ..., 9                      |       |
       * |                                 | SS      | 00, 01, ..., 99                   |       |
       * |                                 | SSS     | 000, 0001, ..., 999               |       |
       * |                                 | SSSS    | ...                               | 3     |
       * | Timezone (ISO-8601 w/ Z)        | X       | -08, +0530, Z                     |       |
       * |                                 | XX      | -0800, +0530, Z                   |       |
       * |                                 | XXX     | -08:00, +05:30, Z                 |       |
       * |                                 | XXXX    | -0800, +0530, Z, +123456          | 2     |
       * |                                 | XXXXX   | -08:00, +05:30, Z, +12:34:56      |       |
       * | Timezone (ISO-8601 w/o Z)       | x       | -08, +0530, +00                   |       |
       * |                                 | xx      | -0800, +0530, +0000               |       |
       * |                                 | xxx     | -08:00, +05:30, +00:00            | 2     |
       * |                                 | xxxx    | -0800, +0530, +0000, +123456      |       |
       * |                                 | xxxxx   | -08:00, +05:30, +00:00, +12:34:56 |       |
       * | Timezone (GMT)                  | O...OOO | GMT-8, GMT+5:30, GMT+0            |       |
       * |                                 | OOOO    | GMT-08:00, GMT+05:30, GMT+00:00   | 2     |
       * | Timezone (specific non-locat.)  | z...zzz | GMT-8, GMT+5:30, GMT+0            | 6     |
       * |                                 | zzzz    | GMT-08:00, GMT+05:30, GMT+00:00   | 2,6   |
       * | Seconds timestamp               | t       | 512969520                         | 7     |
       * |                                 | tt      | ...                               | 3,7   |
       * | Milliseconds timestamp          | T       | 512969520900                      | 7     |
       * |                                 | TT      | ...                               | 3,7   |
       * | Long localized date             | P       | 04/29/1453                        | 7     |
       * |                                 | PP      | Apr 29, 1453                      | 7     |
       * |                                 | PPP     | April 29th, 1453                  | 7     |
       * |                                 | PPPP    | Friday, April 29th, 1453          | 2,7   |
       * | Long localized time             | p       | 12:00 AM                          | 7     |
       * |                                 | pp      | 12:00:00 AM                       | 7     |
       * |                                 | ppp     | 12:00:00 AM GMT+2                 | 7     |
       * |                                 | pppp    | 12:00:00 AM GMT+02:00             | 2,7   |
       * | Combination of date and time    | Pp      | 04/29/1453, 12:00 AM              | 7     |
       * |                                 | PPpp    | Apr 29, 1453, 12:00:00 AM         | 7     |
       * |                                 | PPPppp  | April 29th, 1453 at ...           | 7     |
       * |                                 | PPPPpppp| Friday, April 29th, 1453 at ...   | 2,7   |
       * Notes:
       * 1. "Formatting" units (e.g. formatting quarter) in the default en-US locale
       *    are the same as "stand-alone" units, but are different in some languages.
       *    "Formatting" units are declined according to the rules of the language
       *    in the context of a date. "Stand-alone" units are always nominative singular:
       *
       *    `format(new Date(2017, 10, 6), 'do LLLL', {locale: cs}) //=> '6. listopad'`
       *
       *    `format(new Date(2017, 10, 6), 'do MMMM', {locale: cs}) //=> '6. listopadu'`
       *
       * 2. Any sequence of the identical letters is a pattern, unless it is escaped by
       *    the single quote characters (see below).
       *    If the sequence is longer than listed in table (e.g. `EEEEEEEEEEE`)
       *    the output will be the same as default pattern for this unit, usually
       *    the longest one (in case of ISO weekdays, `EEEE`). Default patterns for units
       *    are marked with "2" in the last column of the table.
       *
       *    `format(new Date(2017, 10, 6), 'MMM') //=> 'Nov'`
       *
       *    `format(new Date(2017, 10, 6), 'MMMM') //=> 'November'`
       *
       *    `format(new Date(2017, 10, 6), 'MMMMM') //=> 'N'`
       *
       *    `format(new Date(2017, 10, 6), 'MMMMMM') //=> 'November'`
       *
       *    `format(new Date(2017, 10, 6), 'MMMMMMM') //=> 'November'`
       *
       * 3. Some patterns could be unlimited length (such as `yyyyyyyy`).
       *    The output will be padded with zeros to match the length of the pattern.
       *
       *    `format(new Date(2017, 10, 6), 'yyyyyyyy') //=> '00002017'`
       *
       * 4. `QQQQQ` and `qqqqq` could be not strictly numerical in some locales.
       *    These tokens represent the shortest form of the quarter.
       *
       * 5. The main difference between `y` and `u` patterns are B.C. years:
       *
       *    | Year | `y` | `u` |
       *    |------|-----|-----|
       *    | AC 1 |   1 |   1 |
       *    | BC 1 |   1 |   0 |
       *    | BC 2 |   2 |  -1 |
       *
       *    Also `yy` always returns the last two digits of a year,
       *    while `uu` pads single digit years to 2 characters and returns other years unchanged:
       *
       *    | Year | `yy` | `uu` |
       *    |------|------|------|
       *    | 1    |   01 |   01 |
       *    | 14   |   14 |   14 |
       *    | 376  |   76 |  376 |
       *    | 1453 |   53 | 1453 |
       *
       *    The same difference is true for local and ISO week-numbering years (`Y` and `R`),
       *    except local week-numbering years are dependent on `options.weekStartsOn`
       *    and `options.firstWeekContainsDate` (compare [getISOWeekYear]{@link https://date-fns.org/docs/getISOWeekYear}
       *    and [getWeekYear]{@link https://date-fns.org/docs/getWeekYear}).
       *
       * 6. Specific non-location timezones are currently unavailable in `date-fns`,
       *    so right now these tokens fall back to GMT timezones.
       *
       * 7. These patterns are not in the Unicode Technical Standard #35:
       *    - `i`: ISO day of week
       *    - `I`: ISO week of year
       *    - `R`: ISO week-numbering year
       *    - `t`: seconds timestamp
       *    - `T`: milliseconds timestamp
       *    - `o`: ordinal number modifier
       *    - `P`: long localized date
       *    - `p`: long localized time
       *
       * 8. `YY` and `YYYY` tokens represent week-numbering years but they are often confused with years.
       *    You should enable `options.useAdditionalWeekYearTokens` to use them. See: https://git.io/fxCyr
       *
       * 9. `D` and `DD` tokens represent days of the year but they are ofthen confused with days of the month.
       *    You should enable `options.useAdditionalDayOfYearTokens` to use them. See: https://git.io/fxCyr
       *
       * ### v2.0.0 breaking changes:
       *
       * - [Changes that are common for the whole library](https://github.com/date-fns/date-fns/blob/master/docs/upgradeGuide.md#Common-Changes).
       *
       * - The second argument is now required for the sake of explicitness.
       *
       *   ```javascript
       *   // Before v2.0.0
       *   format(new Date(2016, 0, 1))
       *
       *   // v2.0.0 onward
       *   format(new Date(2016, 0, 1), "yyyy-MM-dd'T'HH:mm:ss.SSSxxx")
       *   ```
       *
       * - New format string API for `format` function
       *   which is based on [Unicode Technical Standard #35](https://www.unicode.org/reports/tr35/tr35-dates.html#Date_Field_Symbol_Table).
       *   See [this post](https://blog.date-fns.org/post/unicode-tokens-in-date-fns-v2-sreatyki91jg) for more details.
       *
       * - Characters are now escaped using single quote symbols (`'`) instead of square brackets.
       *
       * @param {Date|Number} date - the original date
       * @param {String} format - the string of tokens
       * @param {Object} [options] - an object with options.
       * @param {Locale} [options.locale=defaultLocale] - the locale object. See [Locale]{@link https://date-fns.org/docs/Locale}
       * @param {0|1|2|3|4|5|6} [options.weekStartsOn=0] - the index of the first day of the week (0 - Sunday)
       * @param {Number} [options.firstWeekContainsDate=1] - the day of January, which is
       * @param {Boolean} [options.useAdditionalWeekYearTokens=false] - if true, allows usage of the week-numbering year tokens `YY` and `YYYY`;
       *   see: https://git.io/fxCyr
       * @param {Boolean} [options.useAdditionalDayOfYearTokens=false] - if true, allows usage of the day of year tokens `D` and `DD`;
       *   see: https://git.io/fxCyr
       * @returns {String} the formatted date string
       * @throws {TypeError} 2 arguments required
       * @throws {RangeError} `date` must not be Invalid Date
       * @throws {RangeError} `options.locale` must contain `localize` property
       * @throws {RangeError} `options.locale` must contain `formatLong` property
       * @throws {RangeError} `options.weekStartsOn` must be between 0 and 6
       * @throws {RangeError} `options.firstWeekContainsDate` must be between 1 and 7
       * @throws {RangeError} use `yyyy` instead of `YYYY` for formatting years using [format provided] to the input [input provided]; see: https://git.io/fxCyr
       * @throws {RangeError} use `yy` instead of `YY` for formatting years using [format provided] to the input [input provided]; see: https://git.io/fxCyr
       * @throws {RangeError} use `d` instead of `D` for formatting days of the month using [format provided] to the input [input provided]; see: https://git.io/fxCyr
       * @throws {RangeError} use `dd` instead of `DD` for formatting days of the month using [format provided] to the input [input provided]; see: https://git.io/fxCyr
       * @throws {RangeError} format string contains an unescaped latin alphabet character
       *
       * @example
       * // Represent 11 February 2014 in middle-endian format:
       * var result = format(new Date(2014, 1, 11), 'MM/dd/yyyy')
       * //=> '02/11/2014'
       *
       * @example
       * // Represent 2 July 2014 in Esperanto:
       * import { eoLocale } from 'date-fns/locale/eo'
       * var result = format(new Date(2014, 6, 2), "do 'de' MMMM yyyy", {
       *   locale: eoLocale
       * })
       * //=> '2-a de julio 2014'
       *
       * @example
       * // Escape string by single quote characters:
       * var result = format(new Date(2014, 6, 2, 15), "h 'o''clock'")
       * //=> "3 o'clock"
       */

      function format(dirtyDate, dirtyFormatStr, dirtyOptions) {
        requiredArgs(2, arguments);
        var formatStr = String(dirtyFormatStr);
        var options = dirtyOptions || {};
        var locale$1 = options.locale || locale;
        var localeFirstWeekContainsDate = locale$1.options && locale$1.options.firstWeekContainsDate;
        var defaultFirstWeekContainsDate = localeFirstWeekContainsDate == null ? 1 : toInteger(localeFirstWeekContainsDate);
        var firstWeekContainsDate = options.firstWeekContainsDate == null ? defaultFirstWeekContainsDate : toInteger(options.firstWeekContainsDate); // Test if weekStartsOn is between 1 and 7 _and_ is not NaN

        if (!(firstWeekContainsDate >= 1 && firstWeekContainsDate <= 7)) {
          throw new RangeError('firstWeekContainsDate must be between 1 and 7 inclusively');
        }

        var localeWeekStartsOn = locale$1.options && locale$1.options.weekStartsOn;
        var defaultWeekStartsOn = localeWeekStartsOn == null ? 0 : toInteger(localeWeekStartsOn);
        var weekStartsOn = options.weekStartsOn == null ? defaultWeekStartsOn : toInteger(options.weekStartsOn); // Test if weekStartsOn is between 0 and 6 _and_ is not NaN

        if (!(weekStartsOn >= 0 && weekStartsOn <= 6)) {
          throw new RangeError('weekStartsOn must be between 0 and 6 inclusively');
        }

        if (!locale$1.localize) {
          throw new RangeError('locale must contain localize property');
        }

        if (!locale$1.formatLong) {
          throw new RangeError('locale must contain formatLong property');
        }

        var originalDate = toDate(dirtyDate);

        if (!isValid(originalDate)) {
          throw new RangeError('Invalid time value');
        } // Convert the date in system timezone to the same date in UTC+00:00 timezone.
        // This ensures that when UTC functions will be implemented, locales will be compatible with them.
        // See an issue about UTC functions: https://github.com/date-fns/date-fns/issues/376


        var timezoneOffset = getTimezoneOffsetInMilliseconds(originalDate);
        var utcDate = subMilliseconds(originalDate, timezoneOffset);
        var formatterOptions = {
          firstWeekContainsDate: firstWeekContainsDate,
          weekStartsOn: weekStartsOn,
          locale: locale$1,
          _originalDate: originalDate
        };
        var result = formatStr.match(longFormattingTokensRegExp).map(function (substring) {
          var firstCharacter = substring[0];

          if (firstCharacter === 'p' || firstCharacter === 'P') {
            var longFormatter = longFormatters[firstCharacter];
            return longFormatter(substring, locale$1.formatLong, formatterOptions);
          }

          return substring;
        }).join('').match(formattingTokensRegExp).map(function (substring) {
          // Replace two single quote characters with one single quote character
          if (substring === "''") {
            return "'";
          }

          var firstCharacter = substring[0];

          if (firstCharacter === "'") {
            return cleanEscapedString(substring);
          }

          var formatter = formatters$1[firstCharacter];

          if (formatter) {
            if (!options.useAdditionalWeekYearTokens && isProtectedWeekYearToken(substring)) {
              throwProtectedError(substring, dirtyFormatStr, dirtyDate);
            }

            if (!options.useAdditionalDayOfYearTokens && isProtectedDayOfYearToken(substring)) {
              throwProtectedError(substring, dirtyFormatStr, dirtyDate);
            }

            return formatter(utcDate, substring, locale$1.localize, formatterOptions);
          }

          if (firstCharacter.match(unescapedLatinCharacterRegExp)) {
            throw new RangeError('Format string contains an unescaped latin alphabet character `' + firstCharacter + '`');
          }

          return substring;
        }).join('');
        return result;
      }

      function cleanEscapedString(input) {
        return input.match(escapedStringRegExp)[1].replace(doubleQuoteRegExp, "'");
      }

      function assign(target, dirtyObject) {
        if (target == null) {
          throw new TypeError('assign requires that input parameter not be null or undefined');
        }

        dirtyObject = dirtyObject || {};

        for (var property in dirtyObject) {
          if (dirtyObject.hasOwnProperty(property)) {
            target[property] = dirtyObject[property];
          }
        }

        return target;
      }

// See issue: https://github.com/date-fns/date-fns/issues/376

      function setUTCDay(dirtyDate, dirtyDay, dirtyOptions) {
        requiredArgs(2, arguments);
        var options = dirtyOptions || {};
        var locale = options.locale;
        var localeWeekStartsOn = locale && locale.options && locale.options.weekStartsOn;
        var defaultWeekStartsOn = localeWeekStartsOn == null ? 0 : toInteger(localeWeekStartsOn);
        var weekStartsOn = options.weekStartsOn == null ? defaultWeekStartsOn : toInteger(options.weekStartsOn); // Test if weekStartsOn is between 0 and 6 _and_ is not NaN

        if (!(weekStartsOn >= 0 && weekStartsOn <= 6)) {
          throw new RangeError('weekStartsOn must be between 0 and 6 inclusively');
        }

        var date = toDate(dirtyDate);
        var day = toInteger(dirtyDay);
        var currentDay = date.getUTCDay();
        var remainder = day % 7;
        var dayIndex = (remainder + 7) % 7;
        var diff = (dayIndex < weekStartsOn ? 7 : 0) + day - currentDay;
        date.setUTCDate(date.getUTCDate() + diff);
        return date;
      }

// See issue: https://github.com/date-fns/date-fns/issues/376

      function setUTCISODay(dirtyDate, dirtyDay) {
        requiredArgs(2, arguments);
        var day = toInteger(dirtyDay);

        if (day % 7 === 0) {
          day = day - 7;
        }

        var weekStartsOn = 1;
        var date = toDate(dirtyDate);
        var currentDay = date.getUTCDay();
        var remainder = day % 7;
        var dayIndex = (remainder + 7) % 7;
        var diff = (dayIndex < weekStartsOn ? 7 : 0) + day - currentDay;
        date.setUTCDate(date.getUTCDate() + diff);
        return date;
      }

// See issue: https://github.com/date-fns/date-fns/issues/376

      function setUTCISOWeek(dirtyDate, dirtyISOWeek) {
        requiredArgs(2, arguments);
        var date = toDate(dirtyDate);
        var isoWeek = toInteger(dirtyISOWeek);
        var diff = getUTCISOWeek(date) - isoWeek;
        date.setUTCDate(date.getUTCDate() - diff * 7);
        return date;
      }

// See issue: https://github.com/date-fns/date-fns/issues/376

      function setUTCWeek(dirtyDate, dirtyWeek, options) {
        requiredArgs(2, arguments);
        var date = toDate(dirtyDate);
        var week = toInteger(dirtyWeek);
        var diff = getUTCWeek(date, options) - week;
        date.setUTCDate(date.getUTCDate() - diff * 7);
        return date;
      }

      var MILLISECONDS_IN_HOUR = 3600000;
      var MILLISECONDS_IN_MINUTE$1 = 60000;
      var MILLISECONDS_IN_SECOND = 1000;
      var numericPatterns = {
        month: /^(1[0-2]|0?\d)/,
        // 0 to 12
        date: /^(3[0-1]|[0-2]?\d)/,
        // 0 to 31
        dayOfYear: /^(36[0-6]|3[0-5]\d|[0-2]?\d?\d)/,
        // 0 to 366
        week: /^(5[0-3]|[0-4]?\d)/,
        // 0 to 53
        hour23h: /^(2[0-3]|[0-1]?\d)/,
        // 0 to 23
        hour24h: /^(2[0-4]|[0-1]?\d)/,
        // 0 to 24
        hour11h: /^(1[0-1]|0?\d)/,
        // 0 to 11
        hour12h: /^(1[0-2]|0?\d)/,
        // 0 to 12
        minute: /^[0-5]?\d/,
        // 0 to 59
        second: /^[0-5]?\d/,
        // 0 to 59
        singleDigit: /^\d/,
        // 0 to 9
        twoDigits: /^\d{1,2}/,
        // 0 to 99
        threeDigits: /^\d{1,3}/,
        // 0 to 999
        fourDigits: /^\d{1,4}/,
        // 0 to 9999
        anyDigitsSigned: /^-?\d+/,
        singleDigitSigned: /^-?\d/,
        // 0 to 9, -0 to -9
        twoDigitsSigned: /^-?\d{1,2}/,
        // 0 to 99, -0 to -99
        threeDigitsSigned: /^-?\d{1,3}/,
        // 0 to 999, -0 to -999
        fourDigitsSigned: /^-?\d{1,4}/ // 0 to 9999, -0 to -9999

      };
      var timezonePatterns = {
        basicOptionalMinutes: /^([+-])(\d{2})(\d{2})?|Z/,
        basic: /^([+-])(\d{2})(\d{2})|Z/,
        basicOptionalSeconds: /^([+-])(\d{2})(\d{2})((\d{2}))?|Z/,
        extended: /^([+-])(\d{2}):(\d{2})|Z/,
        extendedOptionalSeconds: /^([+-])(\d{2}):(\d{2})(:(\d{2}))?|Z/
      };

      function parseNumericPattern(pattern, string, valueCallback) {
        var matchResult = string.match(pattern);

        if (!matchResult) {
          return null;
        }

        var value = parseInt(matchResult[0], 10);
        return {
          value: valueCallback ? valueCallback(value) : value,
          rest: string.slice(matchResult[0].length)
        };
      }

      function parseTimezonePattern(pattern, string) {
        var matchResult = string.match(pattern);

        if (!matchResult) {
          return null;
        } // Input is 'Z'


        if (matchResult[0] === 'Z') {
          return {
            value: 0,
            rest: string.slice(1)
          };
        }

        var sign = matchResult[1] === '+' ? 1 : -1;
        var hours = matchResult[2] ? parseInt(matchResult[2], 10) : 0;
        var minutes = matchResult[3] ? parseInt(matchResult[3], 10) : 0;
        var seconds = matchResult[5] ? parseInt(matchResult[5], 10) : 0;
        return {
          value: sign * (hours * MILLISECONDS_IN_HOUR + minutes * MILLISECONDS_IN_MINUTE$1 + seconds * MILLISECONDS_IN_SECOND),
          rest: string.slice(matchResult[0].length)
        };
      }

      function parseAnyDigitsSigned(string, valueCallback) {
        return parseNumericPattern(numericPatterns.anyDigitsSigned, string, valueCallback);
      }

      function parseNDigits(n, string, valueCallback) {
        switch (n) {
          case 1:
            return parseNumericPattern(numericPatterns.singleDigit, string, valueCallback);

          case 2:
            return parseNumericPattern(numericPatterns.twoDigits, string, valueCallback);

          case 3:
            return parseNumericPattern(numericPatterns.threeDigits, string, valueCallback);

          case 4:
            return parseNumericPattern(numericPatterns.fourDigits, string, valueCallback);

          default:
            return parseNumericPattern(new RegExp('^\\d{1,' + n + '}'), string, valueCallback);
        }
      }

      function parseNDigitsSigned(n, string, valueCallback) {
        switch (n) {
          case 1:
            return parseNumericPattern(numericPatterns.singleDigitSigned, string, valueCallback);

          case 2:
            return parseNumericPattern(numericPatterns.twoDigitsSigned, string, valueCallback);

          case 3:
            return parseNumericPattern(numericPatterns.threeDigitsSigned, string, valueCallback);

          case 4:
            return parseNumericPattern(numericPatterns.fourDigitsSigned, string, valueCallback);

          default:
            return parseNumericPattern(new RegExp('^-?\\d{1,' + n + '}'), string, valueCallback);
        }
      }

      function dayPeriodEnumToHours(enumValue) {
        switch (enumValue) {
          case 'morning':
            return 4;

          case 'evening':
            return 17;

          case 'pm':
          case 'noon':
          case 'afternoon':
            return 12;

          case 'am':
          case 'midnight':
          case 'night':
          default:
            return 0;
        }
      }

      function normalizeTwoDigitYear(twoDigitYear, currentYear) {
        var isCommonEra = currentYear > 0; // Absolute number of the current year:
        // 1 -> 1 AC
        // 0 -> 1 BC
        // -1 -> 2 BC

        var absCurrentYear = isCommonEra ? currentYear : 1 - currentYear;
        var result;

        if (absCurrentYear <= 50) {
          result = twoDigitYear || 100;
        } else {
          var rangeEnd = absCurrentYear + 50;
          var rangeEndCentury = Math.floor(rangeEnd / 100) * 100;
          var isPreviousCentury = twoDigitYear >= rangeEnd % 100;
          result = twoDigitYear + rangeEndCentury - (isPreviousCentury ? 100 : 0);
        }

        return isCommonEra ? result : 1 - result;
      }

      var DAYS_IN_MONTH = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
      var DAYS_IN_MONTH_LEAP_YEAR = [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31]; // User for validation

      function isLeapYearIndex(year) {
        return year % 400 === 0 || year % 4 === 0 && year % 100 !== 0;
      }
      /*
 * |     | Unit                           |     | Unit                           |
 * |-----|--------------------------------|-----|--------------------------------|
 * |  a  | AM, PM                         |  A* | Milliseconds in day            |
 * |  b  | AM, PM, noon, midnight         |  B  | Flexible day period            |
 * |  c  | Stand-alone local day of week  |  C* | Localized hour w/ day period   |
 * |  d  | Day of month                   |  D  | Day of year                    |
 * |  e  | Local day of week              |  E  | Day of week                    |
 * |  f  |                                |  F* | Day of week in month           |
 * |  g* | Modified Julian day            |  G  | Era                            |
 * |  h  | Hour [1-12]                    |  H  | Hour [0-23]                    |
 * |  i! | ISO day of week                |  I! | ISO week of year               |
 * |  j* | Localized hour w/ day period   |  J* | Localized hour w/o day period  |
 * |  k  | Hour [1-24]                    |  K  | Hour [0-11]                    |
 * |  l* | (deprecated)                   |  L  | Stand-alone month              |
 * |  m  | Minute                         |  M  | Month                          |
 * |  n  |                                |  N  |                                |
 * |  o! | Ordinal number modifier        |  O* | Timezone (GMT)                 |
 * |  p  |                                |  P  |                                |
 * |  q  | Stand-alone quarter            |  Q  | Quarter                        |
 * |  r* | Related Gregorian year         |  R! | ISO week-numbering year        |
 * |  s  | Second                         |  S  | Fraction of second             |
 * |  t! | Seconds timestamp              |  T! | Milliseconds timestamp         |
 * |  u  | Extended year                  |  U* | Cyclic year                    |
 * |  v* | Timezone (generic non-locat.)  |  V* | Timezone (location)            |
 * |  w  | Local week of year             |  W* | Week of month                  |
 * |  x  | Timezone (ISO-8601 w/o Z)      |  X  | Timezone (ISO-8601)            |
 * |  y  | Year (abs)                     |  Y  | Local week-numbering year      |
 * |  z* | Timezone (specific non-locat.) |  Z* | Timezone (aliases)             |
 *
 * Letters marked by * are not implemented but reserved by Unicode standard.
 *
 * Letters marked by ! are non-standard, but implemented by date-fns:
 * - `o` modifies the previous token to turn it into an ordinal (see `parse` docs)
 * - `i` is ISO day of week. For `i` and `ii` is returns numeric ISO week days,
 *   i.e. 7 for Sunday, 1 for Monday, etc.
 * - `I` is ISO week of year, as opposed to `w` which is local week of year.
 * - `R` is ISO week-numbering year, as opposed to `Y` which is local week-numbering year.
 *   `R` is supposed to be used in conjunction with `I` and `i`
 *   for universal ISO week-numbering date, whereas
 *   `Y` is supposed to be used in conjunction with `w` and `e`
 *   for week-numbering date specific to the locale.
 */


      var parsers = {
        // Era
        G: {
          priority: 140,
          parse: function (string, token, match, _options) {
            switch (token) {
                // AD, BC
              case 'G':
              case 'GG':
              case 'GGG':
                return match.era(string, {
                  width: 'abbreviated'
                }) || match.era(string, {
                  width: 'narrow'
                });
                // A, B

              case 'GGGGG':
                return match.era(string, {
                  width: 'narrow'
                });
                // Anno Domini, Before Christ

              case 'GGGG':
              default:
                return match.era(string, {
                  width: 'wide'
                }) || match.era(string, {
                  width: 'abbreviated'
                }) || match.era(string, {
                  width: 'narrow'
                });
            }
          },
          set: function (date, flags, value, _options) {
            flags.era = value;
            date.setUTCFullYear(value, 0, 1);
            date.setUTCHours(0, 0, 0, 0);
            return date;
          },
          incompatibleTokens: ['R', 'u', 't', 'T']
        },
        // Year
        y: {
          // From http://www.unicode.org/reports/tr35/tr35-31/tr35-dates.html#Date_Format_Patterns
          // | Year     |     y | yy |   yyy |  yyyy | yyyyy |
          // |----------|-------|----|-------|-------|-------|
          // | AD 1     |     1 | 01 |   001 |  0001 | 00001 |
          // | AD 12    |    12 | 12 |   012 |  0012 | 00012 |
          // | AD 123   |   123 | 23 |   123 |  0123 | 00123 |
          // | AD 1234  |  1234 | 34 |  1234 |  1234 | 01234 |
          // | AD 12345 | 12345 | 45 | 12345 | 12345 | 12345 |
          priority: 130,
          parse: function (string, token, match, _options) {
            var valueCallback = function (year) {
              return {
                year: year,
                isTwoDigitYear: token === 'yy'
              };
            };

            switch (token) {
              case 'y':
                return parseNDigits(4, string, valueCallback);

              case 'yo':
                return match.ordinalNumber(string, {
                  unit: 'year',
                  valueCallback: valueCallback
                });

              default:
                return parseNDigits(token.length, string, valueCallback);
            }
          },
          validate: function (_date, value, _options) {
            return value.isTwoDigitYear || value.year > 0;
          },
          set: function (date, flags, value, _options) {
            var currentYear = date.getUTCFullYear();

            if (value.isTwoDigitYear) {
              var normalizedTwoDigitYear = normalizeTwoDigitYear(value.year, currentYear);
              date.setUTCFullYear(normalizedTwoDigitYear, 0, 1);
              date.setUTCHours(0, 0, 0, 0);
              return date;
            }

            var year = !('era' in flags) || flags.era === 1 ? value.year : 1 - value.year;
            date.setUTCFullYear(year, 0, 1);
            date.setUTCHours(0, 0, 0, 0);
            return date;
          },
          incompatibleTokens: ['Y', 'R', 'u', 'w', 'I', 'i', 'e', 'c', 't', 'T']
        },
        // Local week-numbering year
        Y: {
          priority: 130,
          parse: function (string, token, match, _options) {
            var valueCallback = function (year) {
              return {
                year: year,
                isTwoDigitYear: token === 'YY'
              };
            };

            switch (token) {
              case 'Y':
                return parseNDigits(4, string, valueCallback);

              case 'Yo':
                return match.ordinalNumber(string, {
                  unit: 'year',
                  valueCallback: valueCallback
                });

              default:
                return parseNDigits(token.length, string, valueCallback);
            }
          },
          validate: function (_date, value, _options) {
            return value.isTwoDigitYear || value.year > 0;
          },
          set: function (date, flags, value, options) {
            var currentYear = getUTCWeekYear(date, options);

            if (value.isTwoDigitYear) {
              var normalizedTwoDigitYear = normalizeTwoDigitYear(value.year, currentYear);
              date.setUTCFullYear(normalizedTwoDigitYear, 0, options.firstWeekContainsDate);
              date.setUTCHours(0, 0, 0, 0);
              return startOfUTCWeek(date, options);
            }

            var year = !('era' in flags) || flags.era === 1 ? value.year : 1 - value.year;
            date.setUTCFullYear(year, 0, options.firstWeekContainsDate);
            date.setUTCHours(0, 0, 0, 0);
            return startOfUTCWeek(date, options);
          },
          incompatibleTokens: ['y', 'R', 'u', 'Q', 'q', 'M', 'L', 'I', 'd', 'D', 'i', 't', 'T']
        },
        // ISO week-numbering year
        R: {
          priority: 130,
          parse: function (string, token, _match, _options) {
            if (token === 'R') {
              return parseNDigitsSigned(4, string);
            }

            return parseNDigitsSigned(token.length, string);
          },
          set: function (_date, _flags, value, _options) {
            var firstWeekOfYear = new Date(0);
            firstWeekOfYear.setUTCFullYear(value, 0, 4);
            firstWeekOfYear.setUTCHours(0, 0, 0, 0);
            return startOfUTCISOWeek(firstWeekOfYear);
          },
          incompatibleTokens: ['G', 'y', 'Y', 'u', 'Q', 'q', 'M', 'L', 'w', 'd', 'D', 'e', 'c', 't', 'T']
        },
        // Extended year
        u: {
          priority: 130,
          parse: function (string, token, _match, _options) {
            if (token === 'u') {
              return parseNDigitsSigned(4, string);
            }

            return parseNDigitsSigned(token.length, string);
          },
          set: function (date, _flags, value, _options) {
            date.setUTCFullYear(value, 0, 1);
            date.setUTCHours(0, 0, 0, 0);
            return date;
          },
          incompatibleTokens: ['G', 'y', 'Y', 'R', 'w', 'I', 'i', 'e', 'c', 't', 'T']
        },
        // Quarter
        Q: {
          priority: 120,
          parse: function (string, token, match, _options) {
            switch (token) {
                // 1, 2, 3, 4
              case 'Q':
              case 'QQ':
                // 01, 02, 03, 04
                return parseNDigits(token.length, string);
                // 1st, 2nd, 3rd, 4th

              case 'Qo':
                return match.ordinalNumber(string, {
                  unit: 'quarter'
                });
                // Q1, Q2, Q3, Q4

              case 'QQQ':
                return match.quarter(string, {
                  width: 'abbreviated',
                  context: 'formatting'
                }) || match.quarter(string, {
                  width: 'narrow',
                  context: 'formatting'
                });
                // 1, 2, 3, 4 (narrow quarter; could be not numerical)

              case 'QQQQQ':
                return match.quarter(string, {
                  width: 'narrow',
                  context: 'formatting'
                });
                // 1st quarter, 2nd quarter, ...

              case 'QQQQ':
              default:
                return match.quarter(string, {
                  width: 'wide',
                  context: 'formatting'
                }) || match.quarter(string, {
                  width: 'abbreviated',
                  context: 'formatting'
                }) || match.quarter(string, {
                  width: 'narrow',
                  context: 'formatting'
                });
            }
          },
          validate: function (_date, value, _options) {
            return value >= 1 && value <= 4;
          },
          set: function (date, _flags, value, _options) {
            date.setUTCMonth((value - 1) * 3, 1);
            date.setUTCHours(0, 0, 0, 0);
            return date;
          },
          incompatibleTokens: ['Y', 'R', 'q', 'M', 'L', 'w', 'I', 'd', 'D', 'i', 'e', 'c', 't', 'T']
        },
        // Stand-alone quarter
        q: {
          priority: 120,
          parse: function (string, token, match, _options) {
            switch (token) {
                // 1, 2, 3, 4
              case 'q':
              case 'qq':
                // 01, 02, 03, 04
                return parseNDigits(token.length, string);
                // 1st, 2nd, 3rd, 4th

              case 'qo':
                return match.ordinalNumber(string, {
                  unit: 'quarter'
                });
                // Q1, Q2, Q3, Q4

              case 'qqq':
                return match.quarter(string, {
                  width: 'abbreviated',
                  context: 'standalone'
                }) || match.quarter(string, {
                  width: 'narrow',
                  context: 'standalone'
                });
                // 1, 2, 3, 4 (narrow quarter; could be not numerical)

              case 'qqqqq':
                return match.quarter(string, {
                  width: 'narrow',
                  context: 'standalone'
                });
                // 1st quarter, 2nd quarter, ...

              case 'qqqq':
              default:
                return match.quarter(string, {
                  width: 'wide',
                  context: 'standalone'
                }) || match.quarter(string, {
                  width: 'abbreviated',
                  context: 'standalone'
                }) || match.quarter(string, {
                  width: 'narrow',
                  context: 'standalone'
                });
            }
          },
          validate: function (_date, value, _options) {
            return value >= 1 && value <= 4;
          },
          set: function (date, _flags, value, _options) {
            date.setUTCMonth((value - 1) * 3, 1);
            date.setUTCHours(0, 0, 0, 0);
            return date;
          },
          incompatibleTokens: ['Y', 'R', 'Q', 'M', 'L', 'w', 'I', 'd', 'D', 'i', 'e', 'c', 't', 'T']
        },
        // Month
        M: {
          priority: 110,
          parse: function (string, token, match, _options) {
            var valueCallback = function (value) {
              return value - 1;
            };

            switch (token) {
                // 1, 2, ..., 12
              case 'M':
                return parseNumericPattern(numericPatterns.month, string, valueCallback);
                // 01, 02, ..., 12

              case 'MM':
                return parseNDigits(2, string, valueCallback);
                // 1st, 2nd, ..., 12th

              case 'Mo':
                return match.ordinalNumber(string, {
                  unit: 'month',
                  valueCallback: valueCallback
                });
                // Jan, Feb, ..., Dec

              case 'MMM':
                return match.month(string, {
                  width: 'abbreviated',
                  context: 'formatting'
                }) || match.month(string, {
                  width: 'narrow',
                  context: 'formatting'
                });
                // J, F, ..., D

              case 'MMMMM':
                return match.month(string, {
                  width: 'narrow',
                  context: 'formatting'
                });
                // January, February, ..., December

              case 'MMMM':
              default:
                return match.month(string, {
                  width: 'wide',
                  context: 'formatting'
                }) || match.month(string, {
                  width: 'abbreviated',
                  context: 'formatting'
                }) || match.month(string, {
                  width: 'narrow',
                  context: 'formatting'
                });
            }
          },
          validate: function (_date, value, _options) {
            return value >= 0 && value <= 11;
          },
          set: function (date, _flags, value, _options) {
            date.setUTCMonth(value, 1);
            date.setUTCHours(0, 0, 0, 0);
            return date;
          },
          incompatibleTokens: ['Y', 'R', 'q', 'Q', 'L', 'w', 'I', 'D', 'i', 'e', 'c', 't', 'T']
        },
        // Stand-alone month
        L: {
          priority: 110,
          parse: function (string, token, match, _options) {
            var valueCallback = function (value) {
              return value - 1;
            };

            switch (token) {
                // 1, 2, ..., 12
              case 'L':
                return parseNumericPattern(numericPatterns.month, string, valueCallback);
                // 01, 02, ..., 12

              case 'LL':
                return parseNDigits(2, string, valueCallback);
                // 1st, 2nd, ..., 12th

              case 'Lo':
                return match.ordinalNumber(string, {
                  unit: 'month',
                  valueCallback: valueCallback
                });
                // Jan, Feb, ..., Dec

              case 'LLL':
                return match.month(string, {
                  width: 'abbreviated',
                  context: 'standalone'
                }) || match.month(string, {
                  width: 'narrow',
                  context: 'standalone'
                });
                // J, F, ..., D

              case 'LLLLL':
                return match.month(string, {
                  width: 'narrow',
                  context: 'standalone'
                });
                // January, February, ..., December

              case 'LLLL':
              default:
                return match.month(string, {
                  width: 'wide',
                  context: 'standalone'
                }) || match.month(string, {
                  width: 'abbreviated',
                  context: 'standalone'
                }) || match.month(string, {
                  width: 'narrow',
                  context: 'standalone'
                });
            }
          },
          validate: function (_date, value, _options) {
            return value >= 0 && value <= 11;
          },
          set: function (date, _flags, value, _options) {
            date.setUTCMonth(value, 1);
            date.setUTCHours(0, 0, 0, 0);
            return date;
          },
          incompatibleTokens: ['Y', 'R', 'q', 'Q', 'M', 'w', 'I', 'D', 'i', 'e', 'c', 't', 'T']
        },
        // Local week of year
        w: {
          priority: 100,
          parse: function (string, token, match, _options) {
            switch (token) {
              case 'w':
                return parseNumericPattern(numericPatterns.week, string);

              case 'wo':
                return match.ordinalNumber(string, {
                  unit: 'week'
                });

              default:
                return parseNDigits(token.length, string);
            }
          },
          validate: function (_date, value, _options) {
            return value >= 1 && value <= 53;
          },
          set: function (date, _flags, value, options) {
            return startOfUTCWeek(setUTCWeek(date, value, options), options);
          },
          incompatibleTokens: ['y', 'R', 'u', 'q', 'Q', 'M', 'L', 'I', 'd', 'D', 'i', 't', 'T']
        },
        // ISO week of year
        I: {
          priority: 100,
          parse: function (string, token, match, _options) {
            switch (token) {
              case 'I':
                return parseNumericPattern(numericPatterns.week, string);

              case 'Io':
                return match.ordinalNumber(string, {
                  unit: 'week'
                });

              default:
                return parseNDigits(token.length, string);
            }
          },
          validate: function (_date, value, _options) {
            return value >= 1 && value <= 53;
          },
          set: function (date, _flags, value, options) {
            return startOfUTCISOWeek(setUTCISOWeek(date, value, options), options);
          },
          incompatibleTokens: ['y', 'Y', 'u', 'q', 'Q', 'M', 'L', 'w', 'd', 'D', 'e', 'c', 't', 'T']
        },
        // Day of the month
        d: {
          priority: 90,
          subPriority: 1,
          parse: function (string, token, match, _options) {
            switch (token) {
              case 'd':
                return parseNumericPattern(numericPatterns.date, string);

              case 'do':
                return match.ordinalNumber(string, {
                  unit: 'date'
                });

              default:
                return parseNDigits(token.length, string);
            }
          },
          validate: function (date, value, _options) {
            var year = date.getUTCFullYear();
            var isLeapYear = isLeapYearIndex(year);
            var month = date.getUTCMonth();

            if (isLeapYear) {
              return value >= 1 && value <= DAYS_IN_MONTH_LEAP_YEAR[month];
            } else {
              return value >= 1 && value <= DAYS_IN_MONTH[month];
            }
          },
          set: function (date, _flags, value, _options) {
            date.setUTCDate(value);
            date.setUTCHours(0, 0, 0, 0);
            return date;
          },
          incompatibleTokens: ['Y', 'R', 'q', 'Q', 'w', 'I', 'D', 'i', 'e', 'c', 't', 'T']
        },
        // Day of year
        D: {
          priority: 90,
          subPriority: 1,
          parse: function (string, token, match, _options) {
            switch (token) {
              case 'D':
              case 'DD':
                return parseNumericPattern(numericPatterns.dayOfYear, string);

              case 'Do':
                return match.ordinalNumber(string, {
                  unit: 'date'
                });

              default:
                return parseNDigits(token.length, string);
            }
          },
          validate: function (date, value, _options) {
            var year = date.getUTCFullYear();
            var isLeapYear = isLeapYearIndex(year);

            if (isLeapYear) {
              return value >= 1 && value <= 366;
            } else {
              return value >= 1 && value <= 365;
            }
          },
          set: function (date, _flags, value, _options) {
            date.setUTCMonth(0, value);
            date.setUTCHours(0, 0, 0, 0);
            return date;
          },
          incompatibleTokens: ['Y', 'R', 'q', 'Q', 'M', 'L', 'w', 'I', 'd', 'E', 'i', 'e', 'c', 't', 'T']
        },
        // Day of week
        E: {
          priority: 90,
          parse: function (string, token, match, _options) {
            switch (token) {
                // Tue
              case 'E':
              case 'EE':
              case 'EEE':
                return match.day(string, {
                  width: 'abbreviated',
                  context: 'formatting'
                }) || match.day(string, {
                  width: 'short',
                  context: 'formatting'
                }) || match.day(string, {
                  width: 'narrow',
                  context: 'formatting'
                });
                // T

              case 'EEEEE':
                return match.day(string, {
                  width: 'narrow',
                  context: 'formatting'
                });
                // Tu

              case 'EEEEEE':
                return match.day(string, {
                  width: 'short',
                  context: 'formatting'
                }) || match.day(string, {
                  width: 'narrow',
                  context: 'formatting'
                });
                // Tuesday

              case 'EEEE':
              default:
                return match.day(string, {
                  width: 'wide',
                  context: 'formatting'
                }) || match.day(string, {
                  width: 'abbreviated',
                  context: 'formatting'
                }) || match.day(string, {
                  width: 'short',
                  context: 'formatting'
                }) || match.day(string, {
                  width: 'narrow',
                  context: 'formatting'
                });
            }
          },
          validate: function (_date, value, _options) {
            return value >= 0 && value <= 6;
          },
          set: function (date, _flags, value, options) {
            date = setUTCDay(date, value, options);
            date.setUTCHours(0, 0, 0, 0);
            return date;
          },
          incompatibleTokens: ['D', 'i', 'e', 'c', 't', 'T']
        },
        // Local day of week
        e: {
          priority: 90,
          parse: function (string, token, match, options) {
            var valueCallback = function (value) {
              var wholeWeekDays = Math.floor((value - 1) / 7) * 7;
              return (value + options.weekStartsOn + 6) % 7 + wholeWeekDays;
            };

            switch (token) {
                // 3
              case 'e':
              case 'ee':
                // 03
                return parseNDigits(token.length, string, valueCallback);
                // 3rd

              case 'eo':
                return match.ordinalNumber(string, {
                  unit: 'day',
                  valueCallback: valueCallback
                });
                // Tue

              case 'eee':
                return match.day(string, {
                  width: 'abbreviated',
                  context: 'formatting'
                }) || match.day(string, {
                  width: 'short',
                  context: 'formatting'
                }) || match.day(string, {
                  width: 'narrow',
                  context: 'formatting'
                });
                // T

              case 'eeeee':
                return match.day(string, {
                  width: 'narrow',
                  context: 'formatting'
                });
                // Tu

              case 'eeeeee':
                return match.day(string, {
                  width: 'short',
                  context: 'formatting'
                }) || match.day(string, {
                  width: 'narrow',
                  context: 'formatting'
                });
                // Tuesday

              case 'eeee':
              default:
                return match.day(string, {
                  width: 'wide',
                  context: 'formatting'
                }) || match.day(string, {
                  width: 'abbreviated',
                  context: 'formatting'
                }) || match.day(string, {
                  width: 'short',
                  context: 'formatting'
                }) || match.day(string, {
                  width: 'narrow',
                  context: 'formatting'
                });
            }
          },
          validate: function (_date, value, _options) {
            return value >= 0 && value <= 6;
          },
          set: function (date, _flags, value, options) {
            date = setUTCDay(date, value, options);
            date.setUTCHours(0, 0, 0, 0);
            return date;
          },
          incompatibleTokens: ['y', 'R', 'u', 'q', 'Q', 'M', 'L', 'I', 'd', 'D', 'E', 'i', 'c', 't', 'T']
        },
        // Stand-alone local day of week
        c: {
          priority: 90,
          parse: function (string, token, match, options) {
            var valueCallback = function (value) {
              var wholeWeekDays = Math.floor((value - 1) / 7) * 7;
              return (value + options.weekStartsOn + 6) % 7 + wholeWeekDays;
            };

            switch (token) {
                // 3
              case 'c':
              case 'cc':
                // 03
                return parseNDigits(token.length, string, valueCallback);
                // 3rd

              case 'co':
                return match.ordinalNumber(string, {
                  unit: 'day',
                  valueCallback: valueCallback
                });
                // Tue

              case 'ccc':
                return match.day(string, {
                  width: 'abbreviated',
                  context: 'standalone'
                }) || match.day(string, {
                  width: 'short',
                  context: 'standalone'
                }) || match.day(string, {
                  width: 'narrow',
                  context: 'standalone'
                });
                // T

              case 'ccccc':
                return match.day(string, {
                  width: 'narrow',
                  context: 'standalone'
                });
                // Tu

              case 'cccccc':
                return match.day(string, {
                  width: 'short',
                  context: 'standalone'
                }) || match.day(string, {
                  width: 'narrow',
                  context: 'standalone'
                });
                // Tuesday

              case 'cccc':
              default:
                return match.day(string, {
                  width: 'wide',
                  context: 'standalone'
                }) || match.day(string, {
                  width: 'abbreviated',
                  context: 'standalone'
                }) || match.day(string, {
                  width: 'short',
                  context: 'standalone'
                }) || match.day(string, {
                  width: 'narrow',
                  context: 'standalone'
                });
            }
          },
          validate: function (_date, value, _options) {
            return value >= 0 && value <= 6;
          },
          set: function (date, _flags, value, options) {
            date = setUTCDay(date, value, options);
            date.setUTCHours(0, 0, 0, 0);
            return date;
          },
          incompatibleTokens: ['y', 'R', 'u', 'q', 'Q', 'M', 'L', 'I', 'd', 'D', 'E', 'i', 'e', 't', 'T']
        },
        // ISO day of week
        i: {
          priority: 90,
          parse: function (string, token, match, _options) {
            var valueCallback = function (value) {
              if (value === 0) {
                return 7;
              }

              return value;
            };

            switch (token) {
                // 2
              case 'i':
              case 'ii':
                // 02
                return parseNDigits(token.length, string);
                // 2nd

              case 'io':
                return match.ordinalNumber(string, {
                  unit: 'day'
                });
                // Tue

              case 'iii':
                return match.day(string, {
                  width: 'abbreviated',
                  context: 'formatting',
                  valueCallback: valueCallback
                }) || match.day(string, {
                  width: 'short',
                  context: 'formatting',
                  valueCallback: valueCallback
                }) || match.day(string, {
                  width: 'narrow',
                  context: 'formatting',
                  valueCallback: valueCallback
                });
                // T

              case 'iiiii':
                return match.day(string, {
                  width: 'narrow',
                  context: 'formatting',
                  valueCallback: valueCallback
                });
                // Tu

              case 'iiiiii':
                return match.day(string, {
                  width: 'short',
                  context: 'formatting',
                  valueCallback: valueCallback
                }) || match.day(string, {
                  width: 'narrow',
                  context: 'formatting',
                  valueCallback: valueCallback
                });
                // Tuesday

              case 'iiii':
              default:
                return match.day(string, {
                  width: 'wide',
                  context: 'formatting',
                  valueCallback: valueCallback
                }) || match.day(string, {
                  width: 'abbreviated',
                  context: 'formatting',
                  valueCallback: valueCallback
                }) || match.day(string, {
                  width: 'short',
                  context: 'formatting',
                  valueCallback: valueCallback
                }) || match.day(string, {
                  width: 'narrow',
                  context: 'formatting',
                  valueCallback: valueCallback
                });
            }
          },
          validate: function (_date, value, _options) {
            return value >= 1 && value <= 7;
          },
          set: function (date, _flags, value, options) {
            date = setUTCISODay(date, value, options);
            date.setUTCHours(0, 0, 0, 0);
            return date;
          },
          incompatibleTokens: ['y', 'Y', 'u', 'q', 'Q', 'M', 'L', 'w', 'd', 'D', 'E', 'e', 'c', 't', 'T']
        },
        // AM or PM
        a: {
          priority: 80,
          parse: function (string, token, match, _options) {
            switch (token) {
              case 'a':
              case 'aa':
              case 'aaa':
                return match.dayPeriod(string, {
                  width: 'abbreviated',
                  context: 'formatting'
                }) || match.dayPeriod(string, {
                  width: 'narrow',
                  context: 'formatting'
                });

              case 'aaaaa':
                return match.dayPeriod(string, {
                  width: 'narrow',
                  context: 'formatting'
                });

              case 'aaaa':
              default:
                return match.dayPeriod(string, {
                  width: 'wide',
                  context: 'formatting'
                }) || match.dayPeriod(string, {
                  width: 'abbreviated',
                  context: 'formatting'
                }) || match.dayPeriod(string, {
                  width: 'narrow',
                  context: 'formatting'
                });
            }
          },
          set: function (date, _flags, value, _options) {
            date.setUTCHours(dayPeriodEnumToHours(value), 0, 0, 0);
            return date;
          },
          incompatibleTokens: ['b', 'B', 'H', 'K', 'k', 't', 'T']
        },
        // AM, PM, midnight
        b: {
          priority: 80,
          parse: function (string, token, match, _options) {
            switch (token) {
              case 'b':
              case 'bb':
              case 'bbb':
                return match.dayPeriod(string, {
                  width: 'abbreviated',
                  context: 'formatting'
                }) || match.dayPeriod(string, {
                  width: 'narrow',
                  context: 'formatting'
                });

              case 'bbbbb':
                return match.dayPeriod(string, {
                  width: 'narrow',
                  context: 'formatting'
                });

              case 'bbbb':
              default:
                return match.dayPeriod(string, {
                  width: 'wide',
                  context: 'formatting'
                }) || match.dayPeriod(string, {
                  width: 'abbreviated',
                  context: 'formatting'
                }) || match.dayPeriod(string, {
                  width: 'narrow',
                  context: 'formatting'
                });
            }
          },
          set: function (date, _flags, value, _options) {
            date.setUTCHours(dayPeriodEnumToHours(value), 0, 0, 0);
            return date;
          },
          incompatibleTokens: ['a', 'B', 'H', 'K', 'k', 't', 'T']
        },
        // in the morning, in the afternoon, in the evening, at night
        B: {
          priority: 80,
          parse: function (string, token, match, _options) {
            switch (token) {
              case 'B':
              case 'BB':
              case 'BBB':
                return match.dayPeriod(string, {
                  width: 'abbreviated',
                  context: 'formatting'
                }) || match.dayPeriod(string, {
                  width: 'narrow',
                  context: 'formatting'
                });

              case 'BBBBB':
                return match.dayPeriod(string, {
                  width: 'narrow',
                  context: 'formatting'
                });

              case 'BBBB':
              default:
                return match.dayPeriod(string, {
                  width: 'wide',
                  context: 'formatting'
                }) || match.dayPeriod(string, {
                  width: 'abbreviated',
                  context: 'formatting'
                }) || match.dayPeriod(string, {
                  width: 'narrow',
                  context: 'formatting'
                });
            }
          },
          set: function (date, _flags, value, _options) {
            date.setUTCHours(dayPeriodEnumToHours(value), 0, 0, 0);
            return date;
          },
          incompatibleTokens: ['a', 'b', 't', 'T']
        },
        // Hour [1-12]
        h: {
          priority: 70,
          parse: function (string, token, match, _options) {
            switch (token) {
              case 'h':
                return parseNumericPattern(numericPatterns.hour12h, string);

              case 'ho':
                return match.ordinalNumber(string, {
                  unit: 'hour'
                });

              default:
                return parseNDigits(token.length, string);
            }
          },
          validate: function (_date, value, _options) {
            return value >= 1 && value <= 12;
          },
          set: function (date, _flags, value, _options) {
            var isPM = date.getUTCHours() >= 12;

            if (isPM && value < 12) {
              date.setUTCHours(value + 12, 0, 0, 0);
            } else if (!isPM && value === 12) {
              date.setUTCHours(0, 0, 0, 0);
            } else {
              date.setUTCHours(value, 0, 0, 0);
            }

            return date;
          },
          incompatibleTokens: ['H', 'K', 'k', 't', 'T']
        },
        // Hour [0-23]
        H: {
          priority: 70,
          parse: function (string, token, match, _options) {
            switch (token) {
              case 'H':
                return parseNumericPattern(numericPatterns.hour23h, string);

              case 'Ho':
                return match.ordinalNumber(string, {
                  unit: 'hour'
                });

              default:
                return parseNDigits(token.length, string);
            }
          },
          validate: function (_date, value, _options) {
            return value >= 0 && value <= 23;
          },
          set: function (date, _flags, value, _options) {
            date.setUTCHours(value, 0, 0, 0);
            return date;
          },
          incompatibleTokens: ['a', 'b', 'h', 'K', 'k', 't', 'T']
        },
        // Hour [0-11]
        K: {
          priority: 70,
          parse: function (string, token, match, _options) {
            switch (token) {
              case 'K':
                return parseNumericPattern(numericPatterns.hour11h, string);

              case 'Ko':
                return match.ordinalNumber(string, {
                  unit: 'hour'
                });

              default:
                return parseNDigits(token.length, string);
            }
          },
          validate: function (_date, value, _options) {
            return value >= 0 && value <= 11;
          },
          set: function (date, _flags, value, _options) {
            var isPM = date.getUTCHours() >= 12;

            if (isPM && value < 12) {
              date.setUTCHours(value + 12, 0, 0, 0);
            } else {
              date.setUTCHours(value, 0, 0, 0);
            }

            return date;
          },
          incompatibleTokens: ['a', 'b', 'h', 'H', 'k', 't', 'T']
        },
        // Hour [1-24]
        k: {
          priority: 70,
          parse: function (string, token, match, _options) {
            switch (token) {
              case 'k':
                return parseNumericPattern(numericPatterns.hour24h, string);

              case 'ko':
                return match.ordinalNumber(string, {
                  unit: 'hour'
                });

              default:
                return parseNDigits(token.length, string);
            }
          },
          validate: function (_date, value, _options) {
            return value >= 1 && value <= 24;
          },
          set: function (date, _flags, value, _options) {
            var hours = value <= 24 ? value % 24 : value;
            date.setUTCHours(hours, 0, 0, 0);
            return date;
          },
          incompatibleTokens: ['a', 'b', 'h', 'H', 'K', 't', 'T']
        },
        // Minute
        m: {
          priority: 60,
          parse: function (string, token, match, _options) {
            switch (token) {
              case 'm':
                return parseNumericPattern(numericPatterns.minute, string);

              case 'mo':
                return match.ordinalNumber(string, {
                  unit: 'minute'
                });

              default:
                return parseNDigits(token.length, string);
            }
          },
          validate: function (_date, value, _options) {
            return value >= 0 && value <= 59;
          },
          set: function (date, _flags, value, _options) {
            date.setUTCMinutes(value, 0, 0);
            return date;
          },
          incompatibleTokens: ['t', 'T']
        },
        // Second
        s: {
          priority: 50,
          parse: function (string, token, match, _options) {
            switch (token) {
              case 's':
                return parseNumericPattern(numericPatterns.second, string);

              case 'so':
                return match.ordinalNumber(string, {
                  unit: 'second'
                });

              default:
                return parseNDigits(token.length, string);
            }
          },
          validate: function (_date, value, _options) {
            return value >= 0 && value <= 59;
          },
          set: function (date, _flags, value, _options) {
            date.setUTCSeconds(value, 0);
            return date;
          },
          incompatibleTokens: ['t', 'T']
        },
        // Fraction of second
        S: {
          priority: 30,
          parse: function (string, token, _match, _options) {
            var valueCallback = function (value) {
              return Math.floor(value * Math.pow(10, -token.length + 3));
            };

            return parseNDigits(token.length, string, valueCallback);
          },
          set: function (date, _flags, value, _options) {
            date.setUTCMilliseconds(value);
            return date;
          },
          incompatibleTokens: ['t', 'T']
        },
        // Timezone (ISO-8601. +00:00 is `'Z'`)
        X: {
          priority: 10,
          parse: function (string, token, _match, _options) {
            switch (token) {
              case 'X':
                return parseTimezonePattern(timezonePatterns.basicOptionalMinutes, string);

              case 'XX':
                return parseTimezonePattern(timezonePatterns.basic, string);

              case 'XXXX':
                return parseTimezonePattern(timezonePatterns.basicOptionalSeconds, string);

              case 'XXXXX':
                return parseTimezonePattern(timezonePatterns.extendedOptionalSeconds, string);

              case 'XXX':
              default:
                return parseTimezonePattern(timezonePatterns.extended, string);
            }
          },
          set: function (date, flags, value, _options) {
            if (flags.timestampIsSet) {
              return date;
            }

            return new Date(date.getTime() - value);
          },
          incompatibleTokens: ['t', 'T', 'x']
        },
        // Timezone (ISO-8601)
        x: {
          priority: 10,
          parse: function (string, token, _match, _options) {
            switch (token) {
              case 'x':
                return parseTimezonePattern(timezonePatterns.basicOptionalMinutes, string);

              case 'xx':
                return parseTimezonePattern(timezonePatterns.basic, string);

              case 'xxxx':
                return parseTimezonePattern(timezonePatterns.basicOptionalSeconds, string);

              case 'xxxxx':
                return parseTimezonePattern(timezonePatterns.extendedOptionalSeconds, string);

              case 'xxx':
              default:
                return parseTimezonePattern(timezonePatterns.extended, string);
            }
          },
          set: function (date, flags, value, _options) {
            if (flags.timestampIsSet) {
              return date;
            }

            return new Date(date.getTime() - value);
          },
          incompatibleTokens: ['t', 'T', 'X']
        },
        // Seconds timestamp
        t: {
          priority: 40,
          parse: function (string, _token, _match, _options) {
            return parseAnyDigitsSigned(string);
          },
          set: function (_date, _flags, value, _options) {
            return [new Date(value * 1000), {
              timestampIsSet: true
            }];
          },
          incompatibleTokens: '*'
        },
        // Milliseconds timestamp
        T: {
          priority: 20,
          parse: function (string, _token, _match, _options) {
            return parseAnyDigitsSigned(string);
          },
          set: function (_date, _flags, value, _options) {
            return [new Date(value), {
              timestampIsSet: true
            }];
          },
          incompatibleTokens: '*'
        }
      };

      var TIMEZONE_UNIT_PRIORITY = 10; // This RegExp consists of three parts separated by `|`:
// - [yYQqMLwIdDecihHKkms]o matches any available ordinal number token
//   (one of the certain letters followed by `o`)
// - (\w)\1* matches any sequences of the same letter
// - '' matches two quote characters in a row
// - '(''|[^'])+('|$) matches anything surrounded by two quote characters ('),
//   except a single quote symbol, which ends the sequence.
//   Two quote characters do not end the sequence.
//   If there is no matching single quote
//   then the sequence will continue until the end of the string.
// - . matches any single character unmatched by previous parts of the RegExps

      var formattingTokensRegExp$1 = /[yYQqMLwIdDecihHKkms]o|(\w)\1*|''|'(''|[^'])+('|$)|./g; // This RegExp catches symbols escaped by quotes, and also
// sequences of symbols P, p, and the combinations like `PPPPPPPppppp`

      var longFormattingTokensRegExp$1 = /P+p+|P+|p+|''|'(''|[^'])+('|$)|./g;
      var escapedStringRegExp$1 = /^'([^]*?)'?$/;
      var doubleQuoteRegExp$1 = /''/g;
      var notWhitespaceRegExp = /\S/;
      var unescapedLatinCharacterRegExp$1 = /[a-zA-Z]/;
      /**
       * @name parse
       * @category Common Helpers
       * @summary Parse the date.
       *
       * @description
       * Return the date parsed from string using the given format string.
       *
       * > ⚠️ Please note that the `format` tokens differ from Moment.js and other libraries.
       * > See: https://git.io/fxCyr
       *
       * The characters in the format string wrapped between two single quotes characters (') are escaped.
       * Two single quotes in a row, whether inside or outside a quoted sequence, represent a 'real' single quote.
       *
       * Format of the format string is based on Unicode Technical Standard #35:
       * https://www.unicode.org/reports/tr35/tr35-dates.html#Date_Field_Symbol_Table
       * with a few additions (see note 5 below the table).
       *
       * Not all tokens are compatible. Combinations that don't make sense or could lead to bugs are prohibited
       * and will throw `RangeError`. For example usage of 24-hour format token with AM/PM token will throw an exception:
       *
       * ```javascript
       * parse('23 AM', 'HH a', new Date())
       * //=> RangeError: The format string mustn't contain `HH` and `a` at the same time
       * ```
       *
       * See the compatibility table: https://docs.google.com/spreadsheets/d/e/2PACX-1vQOPU3xUhplll6dyoMmVUXHKl_8CRDs6_ueLmex3SoqwhuolkuN3O05l4rqx5h1dKX8eb46Ul-CCSrq/pubhtml?gid=0&single=true
       *
       * Accepted format string patterns:
       * | Unit                            |Prior| Pattern | Result examples                   | Notes |
       * |---------------------------------|-----|---------|-----------------------------------|-------|
       * | Era                             | 140 | G..GGG  | AD, BC                            |       |
       * |                                 |     | GGGG    | Anno Domini, Before Christ        | 2     |
       * |                                 |     | GGGGG   | A, B                              |       |
       * | Calendar year                   | 130 | y       | 44, 1, 1900, 2017, 9999           | 4     |
       * |                                 |     | yo      | 44th, 1st, 1900th, 9999999th      | 4,5   |
       * |                                 |     | yy      | 44, 01, 00, 17                    | 4     |
       * |                                 |     | yyy     | 044, 001, 123, 999                | 4     |
       * |                                 |     | yyyy    | 0044, 0001, 1900, 2017            | 4     |
       * |                                 |     | yyyyy   | ...                               | 2,4   |
       * | Local week-numbering year       | 130 | Y       | 44, 1, 1900, 2017, 9000           | 4     |
       * |                                 |     | Yo      | 44th, 1st, 1900th, 9999999th      | 4,5   |
       * |                                 |     | YY      | 44, 01, 00, 17                    | 4,6   |
       * |                                 |     | YYY     | 044, 001, 123, 999                | 4     |
       * |                                 |     | YYYY    | 0044, 0001, 1900, 2017            | 4,6   |
       * |                                 |     | YYYYY   | ...                               | 2,4   |
       * | ISO week-numbering year         | 130 | R       | -43, 1, 1900, 2017, 9999, -9999   | 4,5   |
       * |                                 |     | RR      | -43, 01, 00, 17                   | 4,5   |
       * |                                 |     | RRR     | -043, 001, 123, 999, -999         | 4,5   |
       * |                                 |     | RRRR    | -0043, 0001, 2017, 9999, -9999    | 4,5   |
       * |                                 |     | RRRRR   | ...                               | 2,4,5 |
       * | Extended year                   | 130 | u       | -43, 1, 1900, 2017, 9999, -999    | 4     |
       * |                                 |     | uu      | -43, 01, 99, -99                  | 4     |
       * |                                 |     | uuu     | -043, 001, 123, 999, -999         | 4     |
       * |                                 |     | uuuu    | -0043, 0001, 2017, 9999, -9999    | 4     |
       * |                                 |     | uuuuu   | ...                               | 2,4   |
       * | Quarter (formatting)            | 120 | Q       | 1, 2, 3, 4                        |       |
       * |                                 |     | Qo      | 1st, 2nd, 3rd, 4th                | 5     |
       * |                                 |     | QQ      | 01, 02, 03, 04                    |       |
       * |                                 |     | QQQ     | Q1, Q2, Q3, Q4                    |       |
       * |                                 |     | QQQQ    | 1st quarter, 2nd quarter, ...     | 2     |
       * |                                 |     | QQQQQ   | 1, 2, 3, 4                        | 4     |
       * | Quarter (stand-alone)           | 120 | q       | 1, 2, 3, 4                        |       |
       * |                                 |     | qo      | 1st, 2nd, 3rd, 4th                | 5     |
       * |                                 |     | qq      | 01, 02, 03, 04                    |       |
       * |                                 |     | qqq     | Q1, Q2, Q3, Q4                    |       |
       * |                                 |     | qqqq    | 1st quarter, 2nd quarter, ...     | 2     |
       * |                                 |     | qqqqq   | 1, 2, 3, 4                        | 3     |
       * | Month (formatting)              | 110 | M       | 1, 2, ..., 12                     |       |
       * |                                 |     | Mo      | 1st, 2nd, ..., 12th               | 5     |
       * |                                 |     | MM      | 01, 02, ..., 12                   |       |
       * |                                 |     | MMM     | Jan, Feb, ..., Dec                |       |
       * |                                 |     | MMMM    | January, February, ..., December  | 2     |
       * |                                 |     | MMMMM   | J, F, ..., D                      |       |
       * | Month (stand-alone)             | 110 | L       | 1, 2, ..., 12                     |       |
       * |                                 |     | Lo      | 1st, 2nd, ..., 12th               | 5     |
       * |                                 |     | LL      | 01, 02, ..., 12                   |       |
       * |                                 |     | LLL     | Jan, Feb, ..., Dec                |       |
       * |                                 |     | LLLL    | January, February, ..., December  | 2     |
       * |                                 |     | LLLLL   | J, F, ..., D                      |       |
       * | Local week of year              | 100 | w       | 1, 2, ..., 53                     |       |
       * |                                 |     | wo      | 1st, 2nd, ..., 53th               | 5     |
       * |                                 |     | ww      | 01, 02, ..., 53                   |       |
       * | ISO week of year                | 100 | I       | 1, 2, ..., 53                     | 5     |
       * |                                 |     | Io      | 1st, 2nd, ..., 53th               | 5     |
       * |                                 |     | II      | 01, 02, ..., 53                   | 5     |
       * | Day of month                    |  90 | d       | 1, 2, ..., 31                     |       |
       * |                                 |     | do      | 1st, 2nd, ..., 31st               | 5     |
       * |                                 |     | dd      | 01, 02, ..., 31                   |       |
       * | Day of year                     |  90 | D       | 1, 2, ..., 365, 366               | 7     |
       * |                                 |     | Do      | 1st, 2nd, ..., 365th, 366th       | 5     |
       * |                                 |     | DD      | 01, 02, ..., 365, 366             | 7     |
       * |                                 |     | DDD     | 001, 002, ..., 365, 366           |       |
       * |                                 |     | DDDD    | ...                               | 2     |
       * | Day of week (formatting)        |  90 | E..EEE  | Mon, Tue, Wed, ..., Sun           |       |
       * |                                 |     | EEEE    | Monday, Tuesday, ..., Sunday      | 2     |
       * |                                 |     | EEEEE   | M, T, W, T, F, S, S               |       |
       * |                                 |     | EEEEEE  | Mo, Tu, We, Th, Fr, Su, Sa        |       |
       * | ISO day of week (formatting)    |  90 | i       | 1, 2, 3, ..., 7                   | 5     |
       * |                                 |     | io      | 1st, 2nd, ..., 7th                | 5     |
       * |                                 |     | ii      | 01, 02, ..., 07                   | 5     |
       * |                                 |     | iii     | Mon, Tue, Wed, ..., Sun           | 5     |
       * |                                 |     | iiii    | Monday, Tuesday, ..., Sunday      | 2,5   |
       * |                                 |     | iiiii   | M, T, W, T, F, S, S               | 5     |
       * |                                 |     | iiiiii  | Mo, Tu, We, Th, Fr, Su, Sa        | 5     |
       * | Local day of week (formatting)  |  90 | e       | 2, 3, 4, ..., 1                   |       |
       * |                                 |     | eo      | 2nd, 3rd, ..., 1st                | 5     |
       * |                                 |     | ee      | 02, 03, ..., 01                   |       |
       * |                                 |     | eee     | Mon, Tue, Wed, ..., Sun           |       |
       * |                                 |     | eeee    | Monday, Tuesday, ..., Sunday      | 2     |
       * |                                 |     | eeeee   | M, T, W, T, F, S, S               |       |
       * |                                 |     | eeeeee  | Mo, Tu, We, Th, Fr, Su, Sa        |       |
       * | Local day of week (stand-alone) |  90 | c       | 2, 3, 4, ..., 1                   |       |
       * |                                 |     | co      | 2nd, 3rd, ..., 1st                | 5     |
       * |                                 |     | cc      | 02, 03, ..., 01                   |       |
       * |                                 |     | ccc     | Mon, Tue, Wed, ..., Sun           |       |
       * |                                 |     | cccc    | Monday, Tuesday, ..., Sunday      | 2     |
       * |                                 |     | ccccc   | M, T, W, T, F, S, S               |       |
       * |                                 |     | cccccc  | Mo, Tu, We, Th, Fr, Su, Sa        |       |
       * | AM, PM                          |  80 | a..aaa  | AM, PM                            |       |
       * |                                 |     | aaaa    | a.m., p.m.                        | 2     |
       * |                                 |     | aaaaa   | a, p                              |       |
       * | AM, PM, noon, midnight          |  80 | b..bbb  | AM, PM, noon, midnight            |       |
       * |                                 |     | bbbb    | a.m., p.m., noon, midnight        | 2     |
       * |                                 |     | bbbbb   | a, p, n, mi                       |       |
       * | Flexible day period             |  80 | B..BBB  | at night, in the morning, ...     |       |
       * |                                 |     | BBBB    | at night, in the morning, ...     | 2     |
       * |                                 |     | BBBBB   | at night, in the morning, ...     |       |
       * | Hour [1-12]                     |  70 | h       | 1, 2, ..., 11, 12                 |       |
       * |                                 |     | ho      | 1st, 2nd, ..., 11th, 12th         | 5     |
       * |                                 |     | hh      | 01, 02, ..., 11, 12               |       |
       * | Hour [0-23]                     |  70 | H       | 0, 1, 2, ..., 23                  |       |
       * |                                 |     | Ho      | 0th, 1st, 2nd, ..., 23rd          | 5     |
       * |                                 |     | HH      | 00, 01, 02, ..., 23               |       |
       * | Hour [0-11]                     |  70 | K       | 1, 2, ..., 11, 0                  |       |
       * |                                 |     | Ko      | 1st, 2nd, ..., 11th, 0th          | 5     |
       * |                                 |     | KK      | 01, 02, ..., 11, 00               |       |
       * | Hour [1-24]                     |  70 | k       | 24, 1, 2, ..., 23                 |       |
       * |                                 |     | ko      | 24th, 1st, 2nd, ..., 23rd         | 5     |
       * |                                 |     | kk      | 24, 01, 02, ..., 23               |       |
       * | Minute                          |  60 | m       | 0, 1, ..., 59                     |       |
       * |                                 |     | mo      | 0th, 1st, ..., 59th               | 5     |
       * |                                 |     | mm      | 00, 01, ..., 59                   |       |
       * | Second                          |  50 | s       | 0, 1, ..., 59                     |       |
       * |                                 |     | so      | 0th, 1st, ..., 59th               | 5     |
       * |                                 |     | ss      | 00, 01, ..., 59                   |       |
       * | Seconds timestamp               |  40 | t       | 512969520                         |       |
       * |                                 |     | tt      | ...                               | 2     |
       * | Fraction of second              |  30 | S       | 0, 1, ..., 9                      |       |
       * |                                 |     | SS      | 00, 01, ..., 99                   |       |
       * |                                 |     | SSS     | 000, 0001, ..., 999               |       |
       * |                                 |     | SSSS    | ...                               | 2     |
       * | Milliseconds timestamp          |  20 | T       | 512969520900                      |       |
       * |                                 |     | TT      | ...                               | 2     |
       * | Timezone (ISO-8601 w/ Z)        |  10 | X       | -08, +0530, Z                     |       |
       * |                                 |     | XX      | -0800, +0530, Z                   |       |
       * |                                 |     | XXX     | -08:00, +05:30, Z                 |       |
       * |                                 |     | XXXX    | -0800, +0530, Z, +123456          | 2     |
       * |                                 |     | XXXXX   | -08:00, +05:30, Z, +12:34:56      |       |
       * | Timezone (ISO-8601 w/o Z)       |  10 | x       | -08, +0530, +00                   |       |
       * |                                 |     | xx      | -0800, +0530, +0000               |       |
       * |                                 |     | xxx     | -08:00, +05:30, +00:00            | 2     |
       * |                                 |     | xxxx    | -0800, +0530, +0000, +123456      |       |
       * |                                 |     | xxxxx   | -08:00, +05:30, +00:00, +12:34:56 |       |
       * | Long localized date             |  NA | P       | 05/29/1453                        | 5,8   |
       * |                                 |     | PP      | May 29, 1453                      |       |
       * |                                 |     | PPP     | May 29th, 1453                    |       |
       * |                                 |     | PPPP    | Sunday, May 29th, 1453            | 2,5,8 |
       * | Long localized time             |  NA | p       | 12:00 AM                          | 5,8   |
       * |                                 |     | pp      | 12:00:00 AM                       |       |
       * | Combination of date and time    |  NA | Pp      | 05/29/1453, 12:00 AM              |       |
       * |                                 |     | PPpp    | May 29, 1453, 12:00:00 AM         |       |
       * |                                 |     | PPPpp   | May 29th, 1453 at ...             |       |
       * |                                 |     | PPPPpp  | Sunday, May 29th, 1453 at ...     | 2,5,8 |
       * Notes:
       * 1. "Formatting" units (e.g. formatting quarter) in the default en-US locale
       *    are the same as "stand-alone" units, but are different in some languages.
       *    "Formatting" units are declined according to the rules of the language
       *    in the context of a date. "Stand-alone" units are always nominative singular.
       *    In `format` function, they will produce different result:
       *
       *    `format(new Date(2017, 10, 6), 'do LLLL', {locale: cs}) //=> '6. listopad'`
       *
       *    `format(new Date(2017, 10, 6), 'do MMMM', {locale: cs}) //=> '6. listopadu'`
       *
       *    `parse` will try to match both formatting and stand-alone units interchangably.
       *
       * 2. Any sequence of the identical letters is a pattern, unless it is escaped by
       *    the single quote characters (see below).
       *    If the sequence is longer than listed in table:
       *    - for numerical units (`yyyyyyyy`) `parse` will try to match a number
       *      as wide as the sequence
       *    - for text units (`MMMMMMMM`) `parse` will try to match the widest variation of the unit.
       *      These variations are marked with "2" in the last column of the table.
       *
       * 3. `QQQQQ` and `qqqqq` could be not strictly numerical in some locales.
       *    These tokens represent the shortest form of the quarter.
       *
       * 4. The main difference between `y` and `u` patterns are B.C. years:
       *
       *    | Year | `y` | `u` |
       *    |------|-----|-----|
       *    | AC 1 |   1 |   1 |
       *    | BC 1 |   1 |   0 |
       *    | BC 2 |   2 |  -1 |
       *
       *    Also `yy` will try to guess the century of two digit year by proximity with `referenceDate`:
       *
       *    `parse('50', 'yy', new Date(2018, 0, 1)) //=> Sat Jan 01 2050 00:00:00`
       *
       *    `parse('75', 'yy', new Date(2018, 0, 1)) //=> Wed Jan 01 1975 00:00:00`
       *
       *    while `uu` will just assign the year as is:
       *
       *    `parse('50', 'uu', new Date(2018, 0, 1)) //=> Sat Jan 01 0050 00:00:00`
       *
       *    `parse('75', 'uu', new Date(2018, 0, 1)) //=> Tue Jan 01 0075 00:00:00`
       *
       *    The same difference is true for local and ISO week-numbering years (`Y` and `R`),
       *    except local week-numbering years are dependent on `options.weekStartsOn`
       *    and `options.firstWeekContainsDate` (compare [setISOWeekYear]{@link https://date-fns.org/docs/setISOWeekYear}
       *    and [setWeekYear]{@link https://date-fns.org/docs/setWeekYear}).
       *
       * 5. These patterns are not in the Unicode Technical Standard #35:
       *    - `i`: ISO day of week
       *    - `I`: ISO week of year
       *    - `R`: ISO week-numbering year
       *    - `o`: ordinal number modifier
       *    - `P`: long localized date
       *    - `p`: long localized time
       *
       * 6. `YY` and `YYYY` tokens represent week-numbering years but they are often confused with years.
       *    You should enable `options.useAdditionalWeekYearTokens` to use them. See: https://git.io/fxCyr
       *
       * 7. `D` and `DD` tokens represent days of the year but they are ofthen confused with days of the month.
       *    You should enable `options.useAdditionalDayOfYearTokens` to use them. See: https://git.io/fxCyr
       *
       * 8. `P+` tokens do not have a defined priority since they are merely aliases to other tokens based
       *    on the given locale.
       *
       *    using `en-US` locale: `P` => `MM/dd/yyyy`
       *    using `en-US` locale: `p` => `hh:mm a`
       *    using `pt-BR` locale: `P` => `dd/MM/yyyy`
       *    using `pt-BR` locale: `p` => `HH:mm`
       *
       * Values will be assigned to the date in the descending order of its unit's priority.
       * Units of an equal priority overwrite each other in the order of appearance.
       *
       * If no values of higher priority are parsed (e.g. when parsing string 'January 1st' without a year),
       * the values will be taken from 3rd argument `referenceDate` which works as a context of parsing.
       *
       * `referenceDate` must be passed for correct work of the function.
       * If you're not sure which `referenceDate` to supply, create a new instance of Date:
       * `parse('02/11/2014', 'MM/dd/yyyy', new Date())`
       * In this case parsing will be done in the context of the current date.
       * If `referenceDate` is `Invalid Date` or a value not convertible to valid `Date`,
       * then `Invalid Date` will be returned.
       *
       * The result may vary by locale.
       *
       * If `formatString` matches with `dateString` but does not provides tokens, `referenceDate` will be returned.
       *
       * If parsing failed, `Invalid Date` will be returned.
       * Invalid Date is a Date, whose time value is NaN.
       * Time value of Date: http://es5.github.io/#x15.9.1.1
       *
       * ### v2.0.0 breaking changes:
       *
       * - [Changes that are common for the whole library](https://github.com/date-fns/date-fns/blob/master/docs/upgradeGuide.md#Common-Changes).
       *
       * - Old `parse` was renamed to `toDate`.
       *   Now `parse` is a new function which parses a string using a provided format.
       *
       *   ```javascript
       *   // Before v2.0.0
       *   parse('2016-01-01')
       *
       *   // v2.0.0 onward (toDate no longer accepts a string)
       *   toDate(1392098430000) // Unix to timestamp
       *   toDate(new Date(2014, 1, 11, 11, 30, 30)) // Cloning the date
       *   parse('2016-01-01', 'yyyy-MM-dd', new Date())
       *   ```
       *
       * @param {String} dateString - the string to parse
       * @param {String} formatString - the string of tokens
       * @param {Date|Number} referenceDate - defines values missing from the parsed dateString
       * @param {Object} [options] - an object with options.
       * @param {Locale} [options.locale=defaultLocale] - the locale object. See [Locale]{@link https://date-fns.org/docs/Locale}
       * @param {0|1|2|3|4|5|6} [options.weekStartsOn=0] - the index of the first day of the week (0 - Sunday)
       * @param {1|2|3|4|5|6|7} [options.firstWeekContainsDate=1] - the day of January, which is always in the first week of the year
       * @param {Boolean} [options.useAdditionalWeekYearTokens=false] - if true, allows usage of the week-numbering year tokens `YY` and `YYYY`;
       *   see: https://git.io/fxCyr
       * @param {Boolean} [options.useAdditionalDayOfYearTokens=false] - if true, allows usage of the day of year tokens `D` and `DD`;
       *   see: https://git.io/fxCyr
       * @returns {Date} the parsed date
       * @throws {TypeError} 3 arguments required
       * @throws {RangeError} `options.weekStartsOn` must be between 0 and 6
       * @throws {RangeError} `options.firstWeekContainsDate` must be between 1 and 7
       * @throws {RangeError} `options.locale` must contain `match` property
       * @throws {RangeError} use `yyyy` instead of `YYYY` for formatting years using [format provided] to the input [input provided]; see: https://git.io/fxCyr
       * @throws {RangeError} use `yy` instead of `YY` for formatting years using [format provided] to the input [input provided]; see: https://git.io/fxCyr
       * @throws {RangeError} use `d` instead of `D` for formatting days of the month using [format provided] to the input [input provided]; see: https://git.io/fxCyr
       * @throws {RangeError} use `dd` instead of `DD` for formatting days of the month using [format provided] to the input [input provided]; see: https://git.io/fxCyr
       * @throws {RangeError} format string contains an unescaped latin alphabet character
       *
       * @example
       * // Parse 11 February 2014 from middle-endian format:
       * var result = parse('02/11/2014', 'MM/dd/yyyy', new Date())
       * //=> Tue Feb 11 2014 00:00:00
       *
       * @example
       * // Parse 28th of February in Esperanto locale in the context of 2010 year:
       * import eo from 'date-fns/locale/eo'
       * var result = parse('28-a de februaro', "do 'de' MMMM", new Date(2010, 0, 1), {
       *   locale: eo
       * })
       * //=> Sun Feb 28 2010 00:00:00
       */

      function parse(dirtyDateString, dirtyFormatString, dirtyReferenceDate, dirtyOptions) {
        requiredArgs(3, arguments);
        var dateString = String(dirtyDateString);
        var formatString = String(dirtyFormatString);
        var options = dirtyOptions || {};
        var locale$1 = options.locale || locale;

        if (!locale$1.match) {
          throw new RangeError('locale must contain match property');
        }

        var localeFirstWeekContainsDate = locale$1.options && locale$1.options.firstWeekContainsDate;
        var defaultFirstWeekContainsDate = localeFirstWeekContainsDate == null ? 1 : toInteger(localeFirstWeekContainsDate);
        var firstWeekContainsDate = options.firstWeekContainsDate == null ? defaultFirstWeekContainsDate : toInteger(options.firstWeekContainsDate); // Test if weekStartsOn is between 1 and 7 _and_ is not NaN

        if (!(firstWeekContainsDate >= 1 && firstWeekContainsDate <= 7)) {
          throw new RangeError('firstWeekContainsDate must be between 1 and 7 inclusively');
        }

        var localeWeekStartsOn = locale$1.options && locale$1.options.weekStartsOn;
        var defaultWeekStartsOn = localeWeekStartsOn == null ? 0 : toInteger(localeWeekStartsOn);
        var weekStartsOn = options.weekStartsOn == null ? defaultWeekStartsOn : toInteger(options.weekStartsOn); // Test if weekStartsOn is between 0 and 6 _and_ is not NaN

        if (!(weekStartsOn >= 0 && weekStartsOn <= 6)) {
          throw new RangeError('weekStartsOn must be between 0 and 6 inclusively');
        }

        if (formatString === '') {
          if (dateString === '') {
            return toDate(dirtyReferenceDate);
          } else {
            return new Date(NaN);
          }
        }

        var subFnOptions = {
          firstWeekContainsDate: firstWeekContainsDate,
          weekStartsOn: weekStartsOn,
          locale: locale$1 // If timezone isn't specified, it will be set to the system timezone

        };
        var setters = [{
          priority: TIMEZONE_UNIT_PRIORITY,
          subPriority: -1,
          set: dateToSystemTimezone,
          index: 0
        }];
        var i;
        var tokens = formatString.match(longFormattingTokensRegExp$1).map(function (substring) {
          var firstCharacter = substring[0];

          if (firstCharacter === 'p' || firstCharacter === 'P') {
            var longFormatter = longFormatters[firstCharacter];
            return longFormatter(substring, locale$1.formatLong, subFnOptions);
          }

          return substring;
        }).join('').match(formattingTokensRegExp$1);
        var usedTokens = [];

        for (i = 0; i < tokens.length; i++) {
          var token = tokens[i];

          if (!options.useAdditionalWeekYearTokens && isProtectedWeekYearToken(token)) {
            throwProtectedError(token, formatString, dirtyDateString);
          }

          if (!options.useAdditionalDayOfYearTokens && isProtectedDayOfYearToken(token)) {
            throwProtectedError(token, formatString, dirtyDateString);
          }

          var firstCharacter = token[0];
          var parser = parsers[firstCharacter];

          if (parser) {
            var incompatibleTokens = parser.incompatibleTokens;

            if (Array.isArray(incompatibleTokens)) {
              var incompatibleToken = void 0;

              for (var _i = 0; _i < usedTokens.length; _i++) {
                var usedToken = usedTokens[_i].token;

                if (incompatibleTokens.indexOf(usedToken) !== -1 || usedToken === firstCharacter) {
                  incompatibleToken = usedTokens[_i];
                  break;
                }
              }

              if (incompatibleToken) {
                throw new RangeError("The format string mustn't contain `".concat(incompatibleToken.fullToken, "` and `").concat(token, "` at the same time"));
              }
            } else if (parser.incompatibleTokens === '*' && usedTokens.length) {
              throw new RangeError("The format string mustn't contain `".concat(token, "` and any other token at the same time"));
            }

            usedTokens.push({
              token: firstCharacter,
              fullToken: token
            });
            var parseResult = parser.parse(dateString, token, locale$1.match, subFnOptions);

            if (!parseResult) {
              return new Date(NaN);
            }

            setters.push({
              priority: parser.priority,
              subPriority: parser.subPriority || 0,
              set: parser.set,
              validate: parser.validate,
              value: parseResult.value,
              index: setters.length
            });
            dateString = parseResult.rest;
          } else {
            if (firstCharacter.match(unescapedLatinCharacterRegExp$1)) {
              throw new RangeError('Format string contains an unescaped latin alphabet character `' + firstCharacter + '`');
            } // Replace two single quote characters with one single quote character


            if (token === "''") {
              token = "'";
            } else if (firstCharacter === "'") {
              token = cleanEscapedString$1(token);
            } // Cut token from string, or, if string doesn't match the token, return Invalid Date


            if (dateString.indexOf(token) === 0) {
              dateString = dateString.slice(token.length);
            } else {
              return new Date(NaN);
            }
          }
        } // Check if the remaining input contains something other than whitespace


        if (dateString.length > 0 && notWhitespaceRegExp.test(dateString)) {
          return new Date(NaN);
        }

        var uniquePrioritySetters = setters.map(function (setter) {
          return setter.priority;
        }).sort(function (a, b) {
          return b - a;
        }).filter(function (priority, index, array) {
          return array.indexOf(priority) === index;
        }).map(function (priority) {
          return setters.filter(function (setter) {
            return setter.priority === priority;
          }).sort(function (a, b) {
            return b.subPriority - a.subPriority;
          });
        }).map(function (setterArray) {
          return setterArray[0];
        });
        var date = toDate(dirtyReferenceDate);

        if (isNaN(date)) {
          return new Date(NaN);
        } // Convert the date in system timezone to the same date in UTC+00:00 timezone.
        // This ensures that when UTC functions will be implemented, locales will be compatible with them.
        // See an issue about UTC functions: https://github.com/date-fns/date-fns/issues/37


        var utcDate = subMilliseconds(date, getTimezoneOffsetInMilliseconds(date));
        var flags = {};

        for (i = 0; i < uniquePrioritySetters.length; i++) {
          var setter = uniquePrioritySetters[i];

          if (setter.validate && !setter.validate(utcDate, setter.value, subFnOptions)) {
            return new Date(NaN);
          }

          var result = setter.set(utcDate, flags, setter.value, subFnOptions); // Result is tuple (date, flags)

          if (result[0]) {
            utcDate = result[0];
            assign(flags, result[1]); // Result is date
          } else {
            utcDate = result;
          }
        }

        return utcDate;
      }

      function dateToSystemTimezone(date, flags) {
        if (flags.timestampIsSet) {
          return date;
        }

        var convertedDate = new Date(0);
        convertedDate.setFullYear(date.getUTCFullYear(), date.getUTCMonth(), date.getUTCDate());
        convertedDate.setHours(date.getUTCHours(), date.getUTCMinutes(), date.getUTCSeconds(), date.getUTCMilliseconds());
        return convertedDate;
      }

      function cleanEscapedString$1(input) {
        return input.match(escapedStringRegExp$1)[1].replace(doubleQuoteRegExp$1, "'");
      }

      var date = Object.assign({}, defaultType);
      date.isRight = true;

      date.compare = function (x, y, column) {
        function cook(d) {
          if (column && column.dateInputFormat) {
            return parse("".concat(d), "".concat(column.dateInputFormat), new Date());
          }

          return d;
        }

        x = cook(x);
        y = cook(y);

        if (!isValid(x)) {
          return -1;
        }

        if (!isValid(y)) {
          return 1;
        }

        return compareAsc(x, y);
      };

      date.format = function (v, column) {
        if (v === undefined || v === null) return ''; // convert to date

        var date = parse(v, column.dateInputFormat, new Date());

        if (isValid(date)) {
          return format(date, column.dateOutputFormat);
        }

        console.error("Not a valid date: \"".concat(v, "\""));
        return null;
      };

      var date$1 = /*#__PURE__*/Object.freeze({
        __proto__: null,
        'default': date
      });

      var number = Object.assign({}, defaultType);
      number.isRight = true;

      number.filterPredicate = function (rowval, filter) {
        return number.compare(rowval, filter) === 0;
      };

      number.compare = function (x, y) {
        function cook(d) {
          // if d is null or undefined we give it the smallest
          // possible value
          if (d === undefined || d === null) return -Infinity;
          return d.indexOf('.') >= 0 ? parseFloat(d) : parseInt(d, 10);
        }

        x = typeof x === 'number' ? x : cook(x);
        y = typeof y === 'number' ? y : cook(y);
        if (x < y) return -1;
        if (x > y) return 1;
        return 0;
      };

      var number$1 = /*#__PURE__*/Object.freeze({
        __proto__: null,
        'default': number
      });

      var decimal = Object.assign({}, number);

      decimal.format = function (v) {
        if (v === undefined || v === null) return '';
        return parseFloat(Math.round(v * 100) / 100).toFixed(2);
      };

      var decimal$1 = /*#__PURE__*/Object.freeze({
        __proto__: null,
        'default': decimal
      });

      var percentage = Object.assign({}, number);

      percentage.format = function (v) {
        if (v === undefined || v === null) return '';
        return "".concat(parseFloat(v * 100).toFixed(2), "%");
      };

      var percentage$1 = /*#__PURE__*/Object.freeze({
        __proto__: null,
        'default': percentage
      });

      var _boolean = Object.assign({}, defaultType);

      _boolean.isRight = true;

      _boolean.filterPredicate = function (rowval, filter) {
        return _boolean.compare(rowval, filter) === 0;
      };

      _boolean.compare = function (x, y) {
        function cook(d) {
          if (typeof d === 'boolean') return d ? 1 : 0;
          if (typeof d === 'string') return d === 'true' ? 1 : 0;
          return -Infinity;
        }

        x = cook(x);
        y = cook(y);
        if (x < y) return -1;
        if (x > y) return 1;
        return 0;
      };

      var _boolean$1 = /*#__PURE__*/Object.freeze({
        __proto__: null,
        'default': _boolean
      });

      var index = {
        date: date$1,
        decimal: decimal$1,
        number: number$1,
        percentage: percentage$1,
        "boolean": _boolean$1
      };

      var dataTypes = {};
      var coreDataTypes = index;
      Object.keys(coreDataTypes).forEach(function (key) {
        var compName = key.replace(/^\.\//, '').replace(/\.js/, '');
        dataTypes[compName] = coreDataTypes[key]["default"];
      });
      var script$6 = {
        name: 'vue-good-table',
        props: {
          isLoading: {
            "default": null,
            type: Boolean
          },
          maxHeight: {
            "default": null,
            type: String
          },
          fixedHeader: Boolean,
          theme: {
            "default": ''
          },
          mode: {
            "default": 'local'
          },
          // could be remote
          totalRows: {},
          // required if mode = 'remote'
          styleClass: {
            "default": 'vgt-table bordered'
          },
          columns: {},
          rows: {},
          lineNumbers: Boolean,
          responsive: {
            "default": true,
            type: Boolean
          },
          rtl: Boolean,
          rowStyleClass: {
            "default": null,
            type: [Function, String]
          },
          compactMode: Boolean,
          groupOptions: {
            "default": function _default() {
              return {
                enabled: false,
                collapsable: false,
                rowKey: null
              };
            }
          },
          selectOptions: {
            "default": function _default() {
              return {
                enabled: false,
                selectionInfoClass: '',
                selectionText: 'rows selected',
                clearSelectionText: 'clear',
                disableSelectInfo: false,
                selectAllByGroup: false
              };
            }
          },
          // sort
          sortOptions: {
            "default": function _default() {
              return {
                enabled: true,
                initialSortBy: [
                  getSortOptions()
                ]
              };
            }
          },
          // pagination
          paginationOptions: {
            "default": function _default() {
              var _ref;

              return _ref = {
                enabled: true,
                position: 'bottom',
                perPage: 10,
                perPageDropdown: null,
                perPageDropdownEnabled: true
              }, _defineProperty(_ref, "position", 'bottom'), _defineProperty(_ref, "dropdownAllowAll", true), _defineProperty(_ref, "mode", 'records'), _defineProperty(_ref, "infoFn", null), _defineProperty(_ref, "jumpFirstOrLast", false), _ref;
            }
          },
          searchOptions: {
            "default": function _default() {
              return {
                enabled: false,
                trigger: null,
                externalQuery: null,
                searchFn: null,
                placeholder: 'Search Table'
              };
            }
          }
        },
        data: function data() {
          return {
            // loading state for remote mode
            tableLoading: false,
            // text options
            firstText: "First",
            lastText: "Last",
            nextText: 'Next',
            prevText: 'Previous',
            rowsPerPageText: 'Rows per page',
            ofText: 'of',
            allText: 'All',
            pageText: 'page',
            // internal select options
            selectable: false,
            selectOnCheckboxOnly: false,
            selectAllByPage: true,
            disableSelectInfo: false,
            selectionInfoClass: '',
            selectionText: 'rows selected',
            clearSelectionText: 'clear',
            // keys for rows that are currently expanded
            maintainExpanded: true,
            expandedRowKeys: new Set(),
            // internal sort options
            sortable: true,
            defaultSortBy: null,
            multipleColumnSort: true,
            // internal search options
            searchEnabled: false,
            searchTrigger: null,
            externalSearchQuery: null,
            searchFn: null,
            searchPlaceholder: 'Search Table',
            searchSkipDiacritics: false,
            // internal pagination options
            perPage: null,
            paginate: false,
            paginateOnTop: false,
            paginateOnBottom: true,
            customRowsPerPageDropdown: [],
            paginateDropdownAllowAll: true,
            paginationMode: 'records',
            paginationInfoFn: null,
            currentPage: 1,
            currentPerPage: 10,
            sorts: [],
            globalSearchTerm: '',
            filteredRows: [],
            columnFilters: {},
            forceSearch: false,
            sortChanged: false,
            dataTypes: dataTypes || {}
          };
        },
        watch: {
          rows: {
            handler: function handler() {
              this.$emit('update:isLoading', false);
              this.filterRows(this.columnFilters, false);
            },
            deep: true,
            immediate: true
          },
          selectOptions: {
            handler: function handler() {
              this.initializeSelect();
            },
            deep: true,
            immediate: true
          },
          paginationOptions: {
            handler: function handler(newValue, oldValue) {
              if (!lodash_isequal(newValue, oldValue)) {
                this.initializePagination();
              }
            },
            deep: true,
            immediate: true
          },
          searchOptions: {
            handler: function handler() {
              if (this.searchOptions.externalQuery !== undefined && this.searchOptions.externalQuery !== this.searchTerm) {
                //* we need to set searchTerm to externalQuery first.
                this.externalSearchQuery = this.searchOptions.externalQuery;
                this.handleSearch();
              }

              this.initializeSearch();
            },
            deep: true,
            immediate: true
          },
          sortOptions: {
            handler: function handler(newValue, oldValue) {
              if (!lodash_isequal(newValue, oldValue)) {
                this.initializeSort();
              }
            },
            deep: true
          },
          selectedRows: function selectedRows(newValue, oldValue) {
            if (!lodash_isequal(newValue, oldValue)) {
              this.$emit('on-selected-rows-change', {
                selectedRows: this.selectedRows
              });
            }
          }
        },
        computed: {
          tableStyles: function tableStyles() {
            if (this.compactMode) return this.tableStyleClasses + 'vgt-compact';else return this.tableStyleClasses;
          },
          hasFooterSlot: function hasFooterSlot() {
            return !!this.$slots['table-actions-bottom'];
          },
          wrapperStyles: function wrapperStyles() {
            return {
              overflow: 'scroll-y',
              maxHeight: this.maxHeight ? this.maxHeight : 'auto'
            };
          },
          rowKeyField: function rowKeyField() {
            return this.groupOptions.rowKey || 'vgt_header_id';
          },
          hasHeaderRowTemplate: function hasHeaderRowTemplate() {
            return !!this.$slots['table-header-row'] || !!this.$scopedSlots['table-header-row'];
          },
          showEmptySlot: function showEmptySlot() {
            if (!this.paginated.length) return true;

            if (this.paginated[0].label === 'no groups' && !this.paginated[0].children.length) {
              return true;
            }

            return false;
          },
          allSelected: function allSelected() {
            return this.selectedRowCount > 0 && (this.selectAllByPage && this.selectedPageRowsCount === this.totalPageRowCount || !this.selectAllByPage && this.selectedRowCount === this.totalRowCount);
          },
          allSelectedIndeterminate: function allSelectedIndeterminate() {
            return !this.allSelected && (this.selectAllByPage && this.selectedPageRowsCount > 0 || !this.selectAllByPage && this.selectedRowCount > 0);
          },
          selectionInfo: function selectionInfo() {
            return "".concat(this.selectedRowCount, " ").concat(this.selectionText);
          },
          selectedRowCount: function selectedRowCount() {
            return this.selectedRows.length;
          },
          selectedPageRowsCount: function selectedPageRowsCount() {
            return this.selectedPageRows.length;
          },
          selectedPageRows: function selectedPageRows() {
            var selectedRows = [];
            this.paginated.forEach(function (headerRow) {
              headerRow.children.forEach(function (row) {
                if (row.vgtSelected) {
                  selectedRows.push(row);
                }
              });
            });
            return selectedRows;
          },
          selectedRows: function selectedRows() {
            var selectedRows = [];
            this.processedRows.forEach(function (headerRow) {
              headerRow.children.forEach(function (row) {
                if (row.vgtSelected) {
                  selectedRows.push(row);
                }
              });
            });
            return selectedRows.sort(function (r1, r2) {
              return r1.originalIndex - r2.originalIndex;
            });
          },
          fullColspan: function fullColspan() {
            var fullColspan = 0;

            for (var i = 0; i < this.columns.length; i += 1) {
              if (!this.columns[i].hidden) {
                fullColspan += 1;
              }
            }

            if (this.lineNumbers) fullColspan++;
            if (this.selectable) fullColspan++;
            return fullColspan;
          },
          groupHeaderOnTop: function groupHeaderOnTop() {
            if (this.groupOptions && this.groupOptions.enabled && this.groupOptions.headerPosition && this.groupOptions.headerPosition === 'bottom') {
              return false;
            }

            if (this.groupOptions && this.groupOptions.enabled) return true; // will only get here if groupOptions is false

            return false;
          },
          groupHeaderOnBottom: function groupHeaderOnBottom() {
            if (this.groupOptions && this.groupOptions.enabled && this.groupOptions.headerPosition && this.groupOptions.headerPosition === 'bottom') {
              return true;
            }

            return false;
          },
          totalRowCount: function totalRowCount() {
            var total = this.processedRows.reduce(function (total, headerRow) {
              var childrenCount = headerRow.children ? headerRow.children.length : 0;
              return total + childrenCount;
            }, 0);
            return total;
          },
          totalPageRowCount: function totalPageRowCount() {
            var total = this.paginated.reduce(function (total, headerRow) {
              var childrenCount = headerRow.children ? headerRow.children.length : 0;
              return total + childrenCount;
            }, 0);
            return total;
          },
          wrapStyleClasses: function wrapStyleClasses() {
            var classes = 'vgt-wrap';
            if (this.rtl) classes += ' rtl';
            classes += " ".concat(this.theme);
            return classes;
          },
          tableStyleClasses: function tableStyleClasses() {
            var classes = this.styleClass;
            classes += " ".concat(this.theme);
            return classes;
          },
          searchTerm: function searchTerm() {
            return this.externalSearchQuery != null ? this.externalSearchQuery : this.globalSearchTerm;
          },
          //
          globalSearchAllowed: function globalSearchAllowed() {
            if (this.searchEnabled && !!this.globalSearchTerm && this.searchTrigger !== 'enter') {
              return true;
            }

            if (this.externalSearchQuery != null && this.searchTrigger !== 'enter') {
              return true;
            }

            if (this.forceSearch) {
              this.forceSearch = false;
              return true;
            }

            return false;
          },
          // this is done everytime sortColumn
          // or sort type changes
          //----------------------------------------
          processedRows: function processedRows() {
            var _this = this;

            // we only process rows when mode is local
            var computedRows = this.filteredRows;

            if (this.mode === 'remote') {
              return computedRows;
            } // take care of the global filter here also


            if (this.globalSearchAllowed) {
              // here also we need to de-construct and then
              // re-construct the rows.
              var allRows = [];
              this.filteredRows.forEach(function (headerRow) {
                allRows.push.apply(allRows, _toConsumableArray(headerRow.children));
              });
              var filteredRows = [];
              allRows.forEach(function (row) {
                for (var i = 0; i < _this.columns.length; i += 1) {
                  var col = _this.columns[i]; // if col does not have search disabled,

                  if (!col.globalSearchDisabled) {
                    // if a search function is provided,
                    // use that for searching, otherwise,
                    // use the default search behavior
                    if (_this.searchFn) {
                      var foundMatch = _this.searchFn(row, col, _this.collectFormatted(row, col), _this.searchTerm);

                      if (foundMatch) {
                        filteredRows.push(row);
                        break; // break the loop
                      }
                    } else {
                      // comparison
                      var matched = defaultType.filterPredicate(_this.collectFormatted(row, col), _this.searchTerm, _this.searchSkipDiacritics);

                      if (matched) {
                        filteredRows.push(row);
                        break; // break loop
                      }
                    }
                  }
                }
              }); // this is where we emit on search

              this.$emit('on-search', {
                searchTerm: this.searchTerm,
                rowCount: filteredRows.length
              }); // here we need to reconstruct the nested structure
              // of rows

              computedRows = [];
              this.filteredRows.forEach(function (headerRow) {
                var i = headerRow.vgt_header_id;
                var children = filteredRows.filter(function (r) {
                  return r.vgt_id === i;
                });

                if (children.length) {
                  var newHeaderRow = JSON.parse(JSON.stringify(headerRow));
                  newHeaderRow.children = children;
                  computedRows.push(newHeaderRow);
                }
              });
            }

            if (this.sorts.length) {
              //* we need to sort
              computedRows.forEach(function (cRows) {
                cRows.children.sort(function (xRow, yRow) {
                  //* we need to get column for each sort
                  var sortValue;

                  for (var i = 0; i < _this.sorts.length; i += 1) {
                    var srt = _this.sorts[i];

                    if (srt.type === SORT_TYPES.None) {
                      //* if no sort, we need to use the original index to sort.
                      sortValue = sortValue || xRow.originalIndex - yRow.originalIndex;
                    } else {
                      var column = _this.getColumnForField(srt.field);

                      var xvalue = _this.collect(xRow, srt.field);

                      var yvalue = _this.collect(yRow, srt.field); //* if a custom sort function has been provided we use that


                      var sortFn = column.sortFn;

                      if (sortFn && typeof sortFn === 'function') {
                        sortValue = sortValue || sortFn(xvalue, yvalue, column, xRow, yRow) * (srt.type === SORT_TYPES.Descending ? -1 : 1);
                      } else {
                        //* else we use our own sort
                        sortValue = sortValue || column.typeDef.compare(xvalue, yvalue, column) * (srt.type === SORT_TYPES.Descending ? -1 : 1);
                      }
                    }
                  }

                  return sortValue;
                });
              });
            } // if the filtering is event based, we need to maintain filter
            // rows


            if (this.searchTrigger === 'enter') {
              this.filteredRows = computedRows;
            }

            return computedRows;
          },
          paginated: function paginated() {
            var _this2 = this;

            if (!this.processedRows.length) return [];

            if (this.mode === 'remote') {
              return this.processedRows;
            } //* flatten the rows for paging.


            var paginatedRows = [];
            this.processedRows.forEach(function (childRows) {
              var _paginatedRows;

              //* only add headers when group options are enabled.
              if (_this2.groupOptions.enabled) {
                paginatedRows.push(childRows);
              }

              (_paginatedRows = paginatedRows).push.apply(_paginatedRows, _toConsumableArray(childRows.children));
            });

            if (this.paginate) {
              var pageStart = (this.currentPage - 1) * this.currentPerPage; // in case of filtering we might be on a page that is
              // not relevant anymore
              // also, if setting to all, current page will not be valid

              if (pageStart >= paginatedRows.length || this.currentPerPage === -1) {
                this.currentPage = 1;
                pageStart = 0;
              } // calculate page end now


              var pageEnd = paginatedRows.length + 1; // if the setting is not set to 'all'

              if (this.currentPerPage !== -1) {
                pageEnd = this.currentPage * this.currentPerPage;
              }

              paginatedRows = paginatedRows.slice(pageStart, pageEnd);
            } // reconstruct paginated rows here


            var reconstructedRows = [];
            paginatedRows.forEach(function (flatRow) {
              //* header row?
              if (flatRow.vgt_header_id !== undefined) {
                _this2.handleExpanded(flatRow);

                var newHeaderRow = JSON.parse(JSON.stringify(flatRow));
                newHeaderRow.children = [];
                reconstructedRows.push(newHeaderRow);
              } else {
                //* child row
                var hRow = reconstructedRows.find(function (r) {
                  return r.vgt_header_id === flatRow.vgt_id;
                });

                if (!hRow) {
                  hRow = _this2.processedRows.find(function (r) {
                    return r.vgt_header_id === flatRow.vgt_id;
                  });

                  if (hRow) {
                    hRow = JSON.parse(JSON.stringify(hRow));
                    hRow.children = [];
                    reconstructedRows.push(hRow);
                  }
                }

                hRow.children.push(flatRow);
              }
            });
            return reconstructedRows;
          },
          originalRows: function originalRows() {
            var rows = this.rows && this.rows.length ? JSON.parse(JSON.stringify(this.rows)) : [];
            var nestedRows = [];

            if (!this.groupOptions.enabled) {
              nestedRows = this.handleGrouped([{
                label: 'no groups',
                children: rows
              }]);
            } else {
              nestedRows = this.handleGrouped(rows);
            } // we need to preserve the original index of
            // rows so lets do that


            var index = 0;
            nestedRows.forEach(function (headerRow) {
              headerRow.children.forEach(function (row) {
                row.originalIndex = index++;
              });
            });
            return nestedRows;
          },
          typedColumns: function typedColumns() {
            var columns = this.columns;

            for (var i = 0; i < this.columns.length; i++) {
              var column = columns[i];
              column.typeDef = this.dataTypes[column.type] || defaultType;
            }

            return columns;
          },
          hasRowClickListener: function hasRowClickListener() {
            return this.$listeners && this.$listeners['on-row-click'];
          }
        },
        methods: {
          //* we need to check for expanded row state here
          //* to maintain it when sorting/filtering
          handleExpanded: function handleExpanded(headerRow) {
            if (this.maintainExpanded && this.expandedRowKeys.has(headerRow[this.rowKeyField])) {
              this.$set(headerRow, 'vgtIsExpanded', true);
            } else {
              this.$set(headerRow, 'vgtIsExpanded', false);
            }
          },
          toggleExpand: function toggleExpand(id) {
            var _this3 = this;

            var headerRow = this.filteredRows.find(function (r) {
              return r[_this3.rowKeyField] === id;
            });

            if (headerRow) {
              this.$set(headerRow, 'vgtIsExpanded', !headerRow.vgtIsExpanded);
            }

            if (this.maintainExpanded && headerRow.vgtIsExpanded) {
              this.expandedRowKeys.add(headerRow[this.rowKeyField]);
            } else {
              this.expandedRowKeys["delete"](headerRow[this.rowKeyField]);
            }
          },
          expandAll: function expandAll() {
            var _this4 = this;

            this.filteredRows.forEach(function (row) {
              _this4.$set(row, 'vgtIsExpanded', true);

              if (_this4.maintainExpanded) {
                _this4.expandedRowKeys.add(row[_this4.rowKeyField]);
              }
            });
          },
          collapseAll: function collapseAll() {
            var _this5 = this;

            this.filteredRows.forEach(function (row) {
              _this5.$set(row, 'vgtIsExpanded', false);

              _this5.expandedRowKeys.clear();
            });
          },
          getColumnForField: function getColumnForField(field) {
            for (var i = 0; i < this.typedColumns.length; i += 1) {
              if (this.typedColumns[i].field === field) return this.typedColumns[i];
            }
          },
          handleSearch: function handleSearch() {
            this.resetTable(); // for remote mode, we need to emit on-search

            if (this.mode === 'remote') {
              this.$emit('on-search', {
                searchTerm: this.searchTerm
              });
            }
          },
          reset: function reset() {
            this.initializeSort();
            this.changePage(1);
            this.$refs['table-header-primary'].reset(true);

            if (this.$refs['table-header-secondary']) {
              this.$refs['table-header-secondary'].reset(true);
            }
          },
          emitSelectedRows: function emitSelectedRows() {
            this.$emit('on-select-all', {
              selected: this.selectedRowCount === this.totalRowCount,
              selectedRows: this.selectedRows
            });
          },
          unselectAllInternal: function unselectAllInternal(forceAll) {
            var _this6 = this;

            var rows = this.selectAllByPage && !forceAll ? this.paginated : this.filteredRows;
            rows.forEach(function (headerRow, i) {
              headerRow.children.forEach(function (row, j) {
                _this6.$set(row, 'vgtSelected', false);
              });
            });
            this.emitSelectedRows();
          },
          toggleSelectAll: function toggleSelectAll() {
            var _this7 = this;

            if (this.allSelected) {
              this.unselectAllInternal();
              return;
            }

            var rows = this.selectAllByPage ? this.paginated : this.filteredRows;
            rows.forEach(function (headerRow) {
              headerRow.children.forEach(function (row) {
                _this7.$set(row, 'vgtSelected', true);
              });
            });
            this.emitSelectedRows();
          },
          toggleSelectGroup: function toggleSelectGroup(event, headerRow) {
            var _this8 = this;

            headerRow.children.forEach(function (row) {
              _this8.$set(row, 'vgtSelected', event.checked);
            });
          },
          changePage: function changePage(value) {
            var enabled = this.paginate;
            var _this$$refs = this.$refs,
                paginationBottom = _this$$refs.paginationBottom,
                paginationTop = _this$$refs.paginationTop;

            if (enabled) {
              if (this.paginateOnTop && paginationTop) {
                paginationTop.currentPage = value;
              }

              if (this.paginateOnBottom && paginationBottom) {
                paginationBottom.currentPage = value;
              } // we also need to set the currentPage
              // for table.


              this.currentPage = value;
            }
          },
          pageChangedEvent: function pageChangedEvent() {
            return {
              currentPage: this.currentPage,
              currentPerPage: this.currentPerPage,
              total: Math.floor(this.totalRowCount / this.currentPerPage)
            };
          },
          pageChanged: function pageChanged(pagination) {
            this.currentPage = pagination.currentPage;

            if (!pagination.noEmit) {
              var pageChangedEvent = this.pageChangedEvent();
              pageChangedEvent.prevPage = pagination.prevPage;
              this.$emit('on-page-change', pageChangedEvent);

              if (this.mode === 'remote') {
                this.$emit('update:isLoading', true);
              }
            }
          },
          perPageChanged: function perPageChanged(pagination) {
            this.currentPerPage = pagination.currentPerPage; // ensure that both sides of pagination are in agreement
            // this fixes changes during position = 'both'

            var paginationPosition = this.paginationOptions.position;

            if (this.$refs.paginationTop && (paginationPosition === 'top' || paginationPosition === 'both')) {
              this.$refs.paginationTop.currentPerPage = this.currentPerPage;
            }

            if (this.$refs.paginationBottom && (paginationPosition === 'bottom' || paginationPosition === 'both')) {
              this.$refs.paginationBottom.currentPerPage = this.currentPerPage;
            } //* update perPage also


            var perPageChangedEvent = this.pageChangedEvent();
            this.$emit('on-per-page-change', perPageChangedEvent);

            if (this.mode === 'remote') {
              this.$emit('update:isLoading', true);
            }
          },
          changeSort: function changeSort(sorts) {
            this.sorts = sorts;
            this.$emit('on-sort-change', sorts); // every time we change sort we need to reset to page 1

            this.changePage(1); // if the mode is remote, we don't need to do anything
            // after this. just set table loading to true

            if (this.mode === 'remote') {
              this.$emit('update:isLoading', true);
              return;
            }

            this.sortChanged = true;
          },
          // checkbox click should always do the following
          onCheckboxClicked: function onCheckboxClicked(row, index, event) {
            this.$set(row, 'vgtSelected', !row.vgtSelected);
            this.$emit('on-row-click', {
              row: row,
              pageIndex: index,
              selected: !!row.vgtSelected,
              event: event
            });
          },
          onRowDoubleClicked: function onRowDoubleClicked(row, index, event) {
            this.$emit('on-row-dblclick', {
              row: row,
              pageIndex: index,
              selected: !!row.vgtSelected,
              event: event
            });
          },
          onRowClicked: function onRowClicked(row, index, event) {
            if (this.selectable && !this.selectOnCheckboxOnly) {
              this.$set(row, 'vgtSelected', !row.vgtSelected);
            }

            this.$emit('on-row-click', {
              row: row,
              pageIndex: index,
              selected: !!row.vgtSelected,
              event: event
            });
          },
          onRowAuxClicked: function onRowAuxClicked(row, index, event) {
            this.$emit('on-row-aux-click', {
              row: row,
              pageIndex: index,
              selected: !!row.vgtSelected,
              event: event
            });
          },
          onCellClicked: function onCellClicked(row, column, rowIndex, event) {
            this.$emit('on-cell-click', {
              row: row,
              column: column,
              rowIndex: rowIndex,
              event: event
            });
          },
          onMouseenter: function onMouseenter(row, index) {
            this.$emit('on-row-mouseenter', {
              row: row,
              pageIndex: index
            });
          },
          onMouseleave: function onMouseleave(row, index) {
            this.$emit('on-row-mouseleave', {
              row: row,
              pageIndex: index
            });
          },
          searchTableOnEnter: function searchTableOnEnter() {
            if (this.searchTrigger === 'enter') {
              this.handleSearch(); // we reset the filteredRows here because
              // we want to search across everything.

              this.filteredRows = JSON.parse(JSON.stringify(this.originalRows));
              this.forceSearch = true;
              this.sortChanged = true;
            }
          },
          searchTableOnKeyUp: function searchTableOnKeyUp() {
            if (this.searchTrigger !== 'enter') {
              this.handleSearch();
            }
          },
          resetTable: function resetTable() {
            this.unselectAllInternal(true); // every time we searchTable

            this.changePage(1);
          },
          // field can be:
          // 1. function (passed as a string using function.name. For example: 'bound myFunction')
          // 2. regular property - ex: 'prop'
          // 3. nested property path - ex: 'nested.prop'
          collect: function collect(obj, field) {
            // utility function to get nested property
            function dig(obj, selector) {
              var result = obj;
              var splitter = selector.split('.');

              for (var i = 0; i < splitter.length; i++) {
                if (typeof result === 'undefined' || result === null) {
                  return undefined;
                }

                result = result[splitter[i]];
              }

              return result;
            }

            if (typeof field === 'function') return field(obj);
            if (typeof field === 'string') return dig(obj, field);
            return undefined;
          },
          collectFormatted: function collectFormatted(obj, column) {
            var headerRow = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;
            var value;

            if (headerRow && column.headerField) {
              value = this.collect(obj, column.headerField);
            } else {
              value = this.collect(obj, column.field);
            }

            if (value === undefined) return ''; // if user has supplied custom formatter,
            // use that here

            if (column.formatFn && typeof column.formatFn === 'function') {
              return column.formatFn(value, obj);
            } // lets format the resultant data


            var type = column.typeDef; // this will only happen if we try to collect formatted
            // before types have been initialized. for example: on
            // load when external query is specified.

            if (!type) {
              type = this.dataTypes[column.type] || defaultType;
            }

            var result = type.format(value, column); // we must have some values in compact mode

            if (this.compactMode && (result == '' || result == null)) return '-';
            return result;
          },
          formattedRow: function formattedRow(row) {
            var isHeaderRow = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
            var formattedRow = {};

            for (var i = 0; i < this.typedColumns.length; i++) {
              var col = this.typedColumns[i]; // what happens if field is

              if (col.field) {
                formattedRow[col.field] = this.collectFormatted(row, col, isHeaderRow);
              }
            }

            return formattedRow;
          },
          // Get classes for the given column index & element.
          getClasses: function getClasses(index, element, row) {
            var _this$typedColumns$in = this.typedColumns[index],
                typeDef = _this$typedColumns$in.typeDef,
                custom = _this$typedColumns$in["".concat(element, "Class")];

            var isRight = typeDef.isRight;
            if (this.rtl) isRight = true;
            var classes = {
              'vgt-right-align': isRight,
              'vgt-left-align': !isRight
            }; // for td we need to check if value is
            // a function.

            if (typeof custom === 'function') {
              classes[custom(row)] = true;
            } else if (typeof custom === 'string') {
              classes[custom] = true;
            }

            return classes;
          },
          // method to filter rows
          filterRows: function filterRows(columnFilters) {
            var _this9 = this;

            var fromFilter = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;
            // if (!this.rows.length) return;
            // this is invoked either as a result of changing filters
            // or as a result of modifying rows.
            this.columnFilters = columnFilters;
            var computedRows = JSON.parse(JSON.stringify(this.originalRows));
            var instancesOfFiltering = false; // do we have a filter to care about?
            // if not we don't need to do anything

            if (this.columnFilters && Object.keys(this.columnFilters).length) {
              var _ret = function () {
                // every time we filter rows, we need to set current page
                // to 1
                // if the mode is remote, we only need to reset, if this is
                // being called from filter, not when rows are changing
                if (_this9.mode !== 'remote' || fromFilter) {
                  _this9.changePage(1);
                } // we need to emit an event and that's that.
                // but this only needs to be invoked if filter is changing
                // not when row object is modified.


                if (fromFilter) {
                  _this9.$emit('on-column-filter', {
                    columnFilters: _this9.columnFilters
                  });
                } // if mode is remote, we don't do any filtering here.


                if (_this9.mode === 'remote') {
                  if (fromFilter) {
                    _this9.$emit('update:isLoading', true);
                  } else {
                    // if remote filtering has already been taken care of.
                    _this9.filteredRows = computedRows;
                  }

                  return {
                    v: void 0
                  };
                }

                var fieldKey = function fieldKey(field) {
                  if (typeof field === 'function' && field.name) {
                    return field.name;
                  }

                  return field;
                };

                var _loop = function _loop(i) {
                  var col = _this9.typedColumns[i];

                  if (_this9.columnFilters[fieldKey(col.field)]) {
                    instancesOfFiltering = true;
                    computedRows.forEach(function (headerRow) {
                      var newChildren = headerRow.children.filter(function (row) {
                        // If column has a custom filter, use that.
                        if (col.filterOptions && typeof col.filterOptions.filterFn === 'function') {
                          return col.filterOptions.filterFn(_this9.collect(row, col.field), _this9.columnFilters[fieldKey(col.field)]);
                        } // Otherwise Use default filters


                        var typeDef = col.typeDef;
                        return typeDef.filterPredicate(_this9.collect(row, col.field), _this9.columnFilters[fieldKey(col.field)], false, col.filterOptions && _typeof(col.filterOptions.filterDropdownItems) === 'object');
                      }); // should we remove the header?

                      headerRow.children = newChildren;
                    });
                  }
                };

                for (var i = 0; i < _this9.typedColumns.length; i++) {
                  _loop(i);
                }
              }();

              if (_typeof(_ret) === "object") return _ret.v;
            }

            if (instancesOfFiltering) {
              this.filteredRows = computedRows.filter(function (h) {
                return h.children && h.children.length;
              });
            } else {
              this.filteredRows = computedRows;
            }
          },
          getCurrentIndex: function getCurrentIndex(rowId) {
            var index = 0;
            var found = false;

            for (var i = 0; i < this.paginated.length; i += 1) {
              var headerRow = this.paginated[i];
              var children = headerRow.children;

              if (children && children.length) {
                for (var j = 0; j < children.length; j += 1) {
                  var c = children[j];

                  if (c.originalIndex === rowId) {
                    found = true;
                    break;
                  }

                  index += 1;
                }
              }

              if (found) break;
            }

            return (this.currentPage - 1) * this.currentPerPage + index + 1;
          },
          getRowStyleClass: function getRowStyleClass(row) {
            var classes = '';
            if (this.hasRowClickListener) classes += 'clickable';
            var rowStyleClasses;

            if (typeof this.rowStyleClass === 'function') {
              rowStyleClasses = this.rowStyleClass(row);
            } else {
              rowStyleClasses = this.rowStyleClass;
            }

            if (rowStyleClasses) {
              classes += " ".concat(rowStyleClasses);
            }

            return classes;
          },
          handleGrouped: function handleGrouped(originalRows) {
            var _this10 = this;

            originalRows.forEach(function (headerRow, i) {
              headerRow.vgt_header_id = i;

              if (_this10.groupOptions.maintainExpanded && _this10.expandedRowKeys.has(headerRow[_this10.groupOptions.rowKey])) {
                _this10.$set(headerRow, 'vgtIsExpanded', true);
              }

              headerRow.children.forEach(function (childRow) {
                childRow.vgt_id = i;
              });
            });
            return originalRows;
          },
          initializePagination: function initializePagination() {
            var _this11 = this;

            var _this$paginationOptio = this.paginationOptions,
                enabled = _this$paginationOptio.enabled,
                perPage = _this$paginationOptio.perPage,
                position = _this$paginationOptio.position,
                perPageDropdown = _this$paginationOptio.perPageDropdown,
                perPageDropdownEnabled = _this$paginationOptio.perPageDropdownEnabled,
                dropdownAllowAll = _this$paginationOptio.dropdownAllowAll,
                firstLabel = _this$paginationOptio.firstLabel,
                lastLabel = _this$paginationOptio.lastLabel,
                nextLabel = _this$paginationOptio.nextLabel,
                prevLabel = _this$paginationOptio.prevLabel,
                rowsPerPageLabel = _this$paginationOptio.rowsPerPageLabel,
                ofLabel = _this$paginationOptio.ofLabel,
                pageLabel = _this$paginationOptio.pageLabel,
                allLabel = _this$paginationOptio.allLabel,
                setCurrentPage = _this$paginationOptio.setCurrentPage,
                mode = _this$paginationOptio.mode,
                infoFn = _this$paginationOptio.infoFn;

            if (typeof enabled === 'boolean') {
              this.paginate = enabled;
            }

            if (typeof perPage === 'number') {
              this.perPage = perPage;
            }

            if (position === 'top') {
              this.paginateOnTop = true; // default is false

              this.paginateOnBottom = false; // default is true
            } else if (position === 'both') {
              this.paginateOnTop = true;
              this.paginateOnBottom = true;
            }

            if (Array.isArray(perPageDropdown) && perPageDropdown.length) {
              this.customRowsPerPageDropdown = perPageDropdown;

              if (!this.perPage) {
                var _perPageDropdown = _slicedToArray(perPageDropdown, 1);

                this.perPage = _perPageDropdown[0];
              }
            }

            if (typeof perPageDropdownEnabled === 'boolean') {
              this.perPageDropdownEnabled = perPageDropdownEnabled;
            }

            if (typeof dropdownAllowAll === 'boolean') {
              this.paginateDropdownAllowAll = dropdownAllowAll;
            }

            if (typeof mode === 'string') {
              this.paginationMode = mode;
            }

            if (typeof firstLabel === 'string') {
              this.firstText = firstLabel;
            }

            if (typeof lastLabel === 'string') {
              this.lastText = lastLabel;
            }

            if (typeof nextLabel === 'string') {
              this.nextText = nextLabel;
            }

            if (typeof prevLabel === 'string') {
              this.prevText = prevLabel;
            }

            if (typeof rowsPerPageLabel === 'string') {
              this.rowsPerPageText = rowsPerPageLabel;
            }

            if (typeof ofLabel === 'string') {
              this.ofText = ofLabel;
            }

            if (typeof pageLabel === 'string') {
              this.pageText = pageLabel;
            }

            if (typeof allLabel === 'string') {
              this.allText = allLabel;
            }

            if (typeof setCurrentPage === 'number') {
              setTimeout(function () {
                _this11.changePage(setCurrentPage);
              }, 500);
            }

            if (typeof infoFn === 'function') {
              this.paginationInfoFn = infoFn;
            }
          },
          initializeSearch: function initializeSearch() {
            var _this$searchOptions = this.searchOptions,
                enabled = _this$searchOptions.enabled,
                trigger = _this$searchOptions.trigger,
                externalQuery = _this$searchOptions.externalQuery,
                searchFn = _this$searchOptions.searchFn,
                placeholder = _this$searchOptions.placeholder,
                skipDiacritics = _this$searchOptions.skipDiacritics;

            if (typeof enabled === 'boolean') {
              this.searchEnabled = enabled;
            }

            if (trigger === 'enter') {
              this.searchTrigger = trigger;
            }

            if (typeof externalQuery === 'string') {
              this.externalSearchQuery = externalQuery;
            }

            if (typeof searchFn === 'function') {
              this.searchFn = searchFn;
            }

            if (typeof placeholder === 'string') {
              this.searchPlaceholder = placeholder;
            }

            if (typeof skipDiacritics === 'boolean') {
              this.searchSkipDiacritics = skipDiacritics;
            }
          },
          initializeSort: function initializeSort() {
            var _this$sortOptions = this.sortOptions,
                enabled = _this$sortOptions.enabled,
                initialSortBy = _this$sortOptions.initialSortBy,
                multipleColumns = _this$sortOptions.multipleColumns;
            var initSortBy = JSON.parse(JSON.stringify(initialSortBy || {}));

            if (typeof enabled === 'boolean') {
              this.sortable = enabled;
            }

            if (typeof multipleColumns === 'boolean') {
              this.multipleColumnSort = multipleColumns;
            } //* initialSortBy can be an array or an object


            if (_typeof(initSortBy) === 'object') {
              var ref = this.fixedHeader ? this.$refs['table-header-secondary'] : this.$refs['table-header-primary'];

              if (Array.isArray(initSortBy)) {
                ref.setInitialSort(initSortBy);
              } else {
                var hasField = Object.prototype.hasOwnProperty.call(initSortBy, 'field');
                if (hasField) ref.setInitialSort([initSortBy]);
              }
            }
          },
          initializeSelect: function initializeSelect() {
            var _this$selectOptions = this.selectOptions,
                enabled = _this$selectOptions.enabled,
                selectionInfoClass = _this$selectOptions.selectionInfoClass,
                selectionText = _this$selectOptions.selectionText,
                clearSelectionText = _this$selectOptions.clearSelectionText,
                selectOnCheckboxOnly = _this$selectOptions.selectOnCheckboxOnly,
                selectAllByPage = _this$selectOptions.selectAllByPage,
                disableSelectInfo = _this$selectOptions.disableSelectInfo,
                selectAllByGroup = _this$selectOptions.selectAllByGroup;

            if (typeof enabled === 'boolean') {
              this.selectable = enabled;
            }

            if (typeof selectOnCheckboxOnly === 'boolean') {
              this.selectOnCheckboxOnly = selectOnCheckboxOnly;
            }

            if (typeof selectAllByPage === 'boolean') {
              this.selectAllByPage = selectAllByPage;
            }

            if (typeof selectAllByGroup === 'boolean') {
              this.selectAllByGroup = selectAllByGroup;
            }

            if (typeof disableSelectInfo === 'boolean') {
              this.disableSelectInfo = disableSelectInfo;
            }

            if (typeof selectionInfoClass === 'string') {
              this.selectionInfoClass = selectionInfoClass;
            }

            if (typeof selectionText === 'string') {
              this.selectionText = selectionText;
            }

            if (typeof clearSelectionText === 'string') {
              this.clearSelectionText = clearSelectionText;
            }
          }
        },
        mounted: function mounted() {
          if (this.perPage) {
            this.currentPerPage = this.perPage;
          }

          this.initializeSort();
        },
        components: {
          'vgt-pagination': __vue_component__$1,
          'vgt-global-search': __vue_component__$2,
          'vgt-header-row': __vue_component__$5,
          'vgt-table-header': __vue_component__$4
        }
      };

      /* script */
      var __vue_script__$6 = script$6;
      /* template */

      var __vue_render__$6 = function __vue_render__() {
        var _vm = this;

        var _h = _vm.$createElement;

        var _c = _vm._self._c || _h;

        return _c('div', {
          "class": _vm.wrapStyleClasses
        }, [_vm.isLoading ? _c('div', {
          staticClass: "vgt-loading vgt-center-align"
        }, [_vm._t("loadingContent", [_c('span', {
          staticClass: "vgt-loading__content"
        }, [_vm._v("\n        Loading...\n      ")])])], 2) : _vm._e(), _vm._v(" "), _c('div', {
          staticClass: "vgt-inner-wrap",
          "class": {
            'is-loading': _vm.isLoading
          }
        }, [_vm.paginate && _vm.paginateOnTop ? _vm._t("pagination-top", [_c('vgt-pagination', {
          ref: "paginationTop",
          attrs: {
            "perPage": _vm.perPage,
            "rtl": _vm.rtl,
            "total": _vm.totalRows || _vm.totalRowCount,
            "mode": _vm.paginationMode,
            "jumpFirstOrLast": _vm.paginationOptions.jumpFirstOrLast,
            "firstText": _vm.firstText,
            "lastText": _vm.lastText,
            "nextText": _vm.nextText,
            "prevText": _vm.prevText,
            "rowsPerPageText": _vm.rowsPerPageText,
            "perPageDropdownEnabled": _vm.paginationOptions.perPageDropdownEnabled,
            "customRowsPerPageDropdown": _vm.customRowsPerPageDropdown,
            "paginateDropdownAllowAll": _vm.paginateDropdownAllowAll,
            "ofText": _vm.ofText,
            "pageText": _vm.pageText,
            "allText": _vm.allText,
            "info-fn": _vm.paginationInfoFn
          },
          on: {
            "page-changed": _vm.pageChanged,
            "per-page-changed": _vm.perPageChanged
          }
        })], {
          "pageChanged": _vm.pageChanged,
          "perPageChanged": _vm.perPageChanged,
          "total": _vm.totalRows || _vm.totalRowCount
        }) : _vm._e(), _vm._v(" "), _c('vgt-global-search', {
          attrs: {
            "search-enabled": _vm.searchEnabled && _vm.externalSearchQuery == null,
            "global-search-placeholder": _vm.searchPlaceholder
          },
          on: {
            "on-keyup": _vm.searchTableOnKeyUp,
            "on-enter": _vm.searchTableOnEnter
          },
          model: {
            value: _vm.globalSearchTerm,
            callback: function callback($$v) {
              _vm.globalSearchTerm = $$v;
            },
            expression: "globalSearchTerm"
          }
        }, [_c('template', {
          slot: "internal-table-actions"
        }, [_vm._t("table-actions")], 2)], 2), _vm._v(" "), _vm.selectedRowCount && !_vm.disableSelectInfo ? _c('div', {
          staticClass: "vgt-selection-info-row clearfix",
          "class": _vm.selectionInfoClass
        }, [_vm._v("\n      " + _vm._s(_vm.selectionInfo) + "\n      "), _c('a', {
          attrs: {
            "href": ""
          },
          on: {
            "click": function click($event) {
              $event.preventDefault();
              return _vm.unselectAllInternal(true);
            }
          }
        }, [_vm._v("\n        " + _vm._s(_vm.clearSelectionText) + "\n      ")]), _vm._v(" "), _c('div', {
          staticClass: "vgt-selection-info-row__actions vgt-pull-right"
        }, [_vm._t("selected-row-actions")], 2)]) : _vm._e(), _vm._v(" "), _c('div', {
          staticClass: "vgt-fixed-header"
        }, [_vm.fixedHeader ? _c('table', {
          "class": _vm.tableStyleClasses,
          attrs: {
            "id": "vgt-table"
          }
        }, [_c('colgroup', _vm._l(_vm.columns, function (column, index) {
          return _c('col', {
            key: index,
            attrs: {
              "id": "col-" + index
            }
          });
        }), 0), _vm._v(" "), _c("vgt-table-header", {
          ref: "table-header-secondary",
          tag: "thead",
          attrs: {
            "columns": _vm.columns,
            "line-numbers": _vm.lineNumbers,
            "selectable": _vm.selectable,
            "all-selected": _vm.allSelected,
            "all-selected-indeterminate": _vm.allSelectedIndeterminate,
            "mode": _vm.mode,
            "sortable": _vm.sortable,
            "multiple-column-sort": _vm.multipleColumnSort,
            "typed-columns": _vm.typedColumns,
            "getClasses": _vm.getClasses,
            "searchEnabled": _vm.searchEnabled,
            "paginated": _vm.paginated,
            "table-ref": _vm.$refs.table
          },
          on: {
            "on-toggle-select-all": _vm.toggleSelectAll,
            "on-sort-change": _vm.changeSort,
            "filter-changed": _vm.filterRows
          },
          scopedSlots: _vm._u([{
            key: "table-column",
            fn: function fn(props) {
              return [_vm._t("table-column", [_c('span', [_vm._v(_vm._s(props.column.label))])], {
                "column": props.column
              })];
            }
          }, {
            key: "column-filter",
            fn: function fn(props) {
              return [_vm._t("column-filter", null, {
                "column": props.column,
                "updateFilters": props.updateFilters
              })];
            }
          }], null, true)
        })], 1) : _vm._e()]), _vm._v(" "), _c('div', {
          "class": {
            'vgt-responsive': _vm.responsive
          },
          style: _vm.wrapperStyles
        }, [_c('table', {
          ref: "table",
          "class": _vm.tableStyles,
          attrs: {
            "id": "vgt-table"
          }
        }, [_c('colgroup', _vm._l(_vm.columns, function (column, index) {
          return _c('col', {
            key: index,
            attrs: {
              "id": "col-" + index
            }
          });
        }), 0), _vm._v(" "), _c("vgt-table-header", {
          ref: "table-header-primary",
          tag: "thead",
          attrs: {
            "columns": _vm.columns,
            "line-numbers": _vm.lineNumbers,
            "selectable": _vm.selectable,
            "all-selected": _vm.allSelected,
            "all-selected-indeterminate": _vm.allSelectedIndeterminate,
            "mode": _vm.mode,
            "sortable": _vm.sortable,
            "multiple-column-sort": _vm.multipleColumnSort,
            "typed-columns": _vm.typedColumns,
            "getClasses": _vm.getClasses,
            "searchEnabled": _vm.searchEnabled
          },
          on: {
            "on-toggle-select-all": _vm.toggleSelectAll,
            "on-sort-change": _vm.changeSort,
            "filter-changed": _vm.filterRows
          },
          scopedSlots: _vm._u([{
            key: "table-column",
            fn: function fn(props) {
              return [_vm._t("table-column", [_c('span', [_vm._v(_vm._s(props.column.label))])], {
                "column": props.column
              })];
            }
          }, {
            key: "column-filter",
            fn: function fn(props) {
              return [_vm._t("column-filter", null, {
                "column": props.column,
                "updateFilters": props.updateFilters
              })];
            }
          }], null, true)
        }), _vm._v(" "), _vm._l(_vm.paginated, function (headerRow, hIndex) {
          return _c('tbody', {
            key: hIndex
          }, [_vm.groupHeaderOnTop ? _c('vgt-header-row', {
            "class": _vm.getRowStyleClass(headerRow),
            attrs: {
              "header-row": headerRow,
              "columns": _vm.columns,
              "line-numbers": _vm.lineNumbers,
              "selectable": _vm.selectable,
              "select-all-by-group": _vm.selectAllByGroup,
              "collapsable": _vm.groupOptions.collapsable,
              "collect-formatted": _vm.collectFormatted,
              "formatted-row": _vm.formattedRow,
              "get-classes": _vm.getClasses,
              "full-colspan": _vm.fullColspan,
              "groupIndex": hIndex
            },
            on: {
              "vgtExpand": function vgtExpand($event) {
                return _vm.toggleExpand(headerRow[_vm.rowKeyField]);
              },
              "on-select-group-change": function onSelectGroupChange($event) {
                return _vm.toggleSelectGroup($event, headerRow);
              }
            },
            scopedSlots: _vm._u([{
              key: "table-header-row",
              fn: function fn(props) {
                return _vm.hasHeaderRowTemplate ? [_vm._t("table-header-row", null, {
                  "column": props.column,
                  "formattedRow": props.formattedRow,
                  "row": props.row
                })] : undefined;
              }
            }], null, true)
          }) : _vm._e(), _vm._v(" "), _vm._l(headerRow.children, function (row, index) {
            return (_vm.groupOptions.collapsable ? headerRow.vgtIsExpanded : true) ? _c('tr', {
              key: row.originalIndex,
              "class": _vm.getRowStyleClass(row),
              on: {
                "mouseenter": function mouseenter($event) {
                  return _vm.onMouseenter(row, index);
                },
                "mouseleave": function mouseleave($event) {
                  return _vm.onMouseleave(row, index);
                },
                "dblclick": function dblclick($event) {
                  return _vm.onRowDoubleClicked(row, index, $event);
                },
                "click": function click($event) {
                  return _vm.onRowClicked(row, index, $event);
                },
                "auxclick": function auxclick($event) {
                  return _vm.onRowAuxClicked(row, index, $event);
                }
              }
            }, [_vm.lineNumbers ? _c('th', {
              staticClass: "line-numbers"
            }, [_vm._v("\n              " + _vm._s(_vm.getCurrentIndex(row.originalIndex)) + "\n            ")]) : _vm._e(), _vm._v(" "), _vm.selectable ? _c('th', {
              staticClass: "vgt-checkbox-col",
              on: {
                "click": function click($event) {
                  $event.stopPropagation();
                  return _vm.onCheckboxClicked(row, index, $event);
                }
              }
            }, [_c('input', {
              attrs: {
                "type": "checkbox",
                "disabled": row.vgtDisabled
              },
              domProps: {
                "checked": row.vgtSelected
              }
            })]) : _vm._e(), _vm._v(" "), _vm._l(_vm.columns, function (column, i) {
              return !column.hidden && column.field ? _c('td', {
                key: i,
                "class": _vm.getClasses(i, 'td', row),
                attrs: {
                  "data-label": _vm.compactMode ? column.label : undefined
                },
                on: {
                  "click": function click($event) {
                    return _vm.onCellClicked(row, column, index, $event);
                  }
                }
              }, [_vm._t("table-row", [!column.html ? _c('span', [_vm._v("\n                  " + _vm._s(_vm.collectFormatted(row, column)) + "\n                ")]) : _c('span', {
                domProps: {
                  "innerHTML": _vm._s(_vm.collect(row, column.field))
                }
              })], {
                "row": row,
                "column": column,
                "formattedRow": _vm.formattedRow(row),
                "index": index
              })], 2) : _vm._e();
            })], 2) : _vm._e();
          }), _vm._v(" "), _vm.groupHeaderOnBottom ? _c('vgt-header-row', {
            attrs: {
              "header-row": headerRow,
              "columns": _vm.columns,
              "line-numbers": _vm.lineNumbers,
              "selectable": _vm.selectable,
              "select-all-by-group": _vm.selectAllByGroup,
              "collect-formatted": _vm.collectFormatted,
              "formatted-row": _vm.formattedRow,
              "get-classes": _vm.getClasses,
              "full-colspan": _vm.fullColspan,
              "groupIndex": _vm.index
            },
            on: {
              "on-select-group-change": function onSelectGroupChange($event) {
                return _vm.toggleSelectGroup($event, headerRow);
              }
            },
            scopedSlots: _vm._u([{
              key: "table-header-row",
              fn: function fn(props) {
                return _vm.hasHeaderRowTemplate ? [_vm._t("table-header-row", null, {
                  "column": props.column,
                  "formattedRow": props.formattedRow,
                  "row": props.row
                })] : undefined;
              }
            }], null, true)
          }) : _vm._e()], 2);
        }), _vm._v(" "), _vm.showEmptySlot ? _c('tbody', [_c('tr', [_c('td', {
          attrs: {
            "colspan": _vm.fullColspan
          }
        }, [_vm._t("emptystate", [_c('div', {
          staticClass: "vgt-center-align vgt-text-disabled"
        }, [_vm._v("\n                  No data for table\n                ")])])], 2)])]) : _vm._e()], 2)]), _vm._v(" "), _vm.hasFooterSlot ? _c('div', {
          staticClass: "vgt-wrap__actions-footer"
        }, [_vm._t("table-actions-bottom")], 2) : _vm._e(), _vm._v(" "), _vm.paginate && _vm.paginateOnBottom ? _vm._t("pagination-bottom", [_c('vgt-pagination', {
          ref: "paginationBottom",
          attrs: {
            "perPage": _vm.perPage,
            "rtl": _vm.rtl,
            "total": _vm.totalRows || _vm.totalRowCount,
            "mode": _vm.paginationMode,
            "jumpFirstOrLast": _vm.paginationOptions.jumpFirstOrLast,
            "firstText": _vm.firstText,
            "lastText": _vm.lastText,
            "nextText": _vm.nextText,
            "prevText": _vm.prevText,
            "rowsPerPageText": _vm.rowsPerPageText,
            "perPageDropdownEnabled": _vm.paginationOptions.perPageDropdownEnabled,
            "customRowsPerPageDropdown": _vm.customRowsPerPageDropdown,
            "paginateDropdownAllowAll": _vm.paginateDropdownAllowAll,
            "ofText": _vm.ofText,
            "pageText": _vm.pageText,
            "allText": _vm.allText,
            "info-fn": _vm.paginationInfoFn
          },
          on: {
            "page-changed": _vm.pageChanged,
            "per-page-changed": _vm.perPageChanged
          }
        })], {
          "pageChanged": _vm.pageChanged,
          "perPageChanged": _vm.perPageChanged,
          "total": _vm.totalRows || _vm.totalRowCount
        }) : _vm._e()], 2)]);
      };

      var __vue_staticRenderFns__$6 = [];
      /* style */

      var __vue_inject_styles__$6 = undefined;
      /* scoped */

      var __vue_scope_id__$6 = undefined;
      /* module identifier */

      var __vue_module_identifier__$6 = undefined;
      /* functional template */

      var __vue_is_functional_template__$6 = false;
      /* style inject */

      /* style inject SSR */

      /* style inject shadow dom */

      var __vue_component__$6 = /*#__PURE__*/normalizeComponent({
        render: __vue_render__$6,
        staticRenderFns: __vue_staticRenderFns__$6
      }, __vue_inject_styles__$6, __vue_script__$6, __vue_scope_id__$6, __vue_is_functional_template__$6, __vue_module_identifier__$6, false, undefined, undefined, undefined);

      var VueGoodTablePlugin = {
        install: function install(Vue, options) {
          Vue.component(__vue_component__$6.name, __vue_component__$6);
        }
      }; // Automatic installation if Vue has been added to the global scope.

      if (typeof window !== 'undefined' && window.Vue) {
        window.Vue.use(VueGoodTablePlugin);
      }

      /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (VueGoodTablePlugin);



      /***/ }),

    /***/ "./node_modules/vue-toastification/dist/esm/index.js":
    /*!***********************************************************!*\
  !*** ./node_modules/vue-toastification/dist/esm/index.js ***!
  \***********************************************************/
    /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

      "use strict";
      __webpack_require__.r(__webpack_exports__);
      /* harmony export */ __webpack_require__.d(__webpack_exports__, {
        /* harmony export */   "POSITION": () => (/* binding */ POSITION),
        /* harmony export */   "TYPE": () => (/* binding */ TYPE),
        /* harmony export */   "createToastInterface": () => (/* binding */ createToastInterface),
        /* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
        /* harmony export */ });
      /* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm.js");


      /*! *****************************************************************************
Copyright (c) Microsoft Corporation.

Permission to use, copy, modify, and/or distribute this software for any
purpose with or without fee is hereby granted.

THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES WITH
REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF MERCHANTABILITY
AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY SPECIAL, DIRECT,
INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES WHATSOEVER RESULTING FROM
LOSS OF USE, DATA OR PROFITS, WHETHER IN AN ACTION OF CONTRACT, NEGLIGENCE OR
OTHER TORTIOUS ACTION, ARISING OUT OF OR IN CONNECTION WITH THE USE OR
PERFORMANCE OF THIS SOFTWARE.
***************************************************************************** */

      function __awaiter(thisArg, _arguments, P, generator) {
        function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
        return new (P || (P = Promise))(function (resolve, reject) {
          function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
          function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
          function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
          step((generator = generator.apply(thisArg, _arguments || [])).next());
        });
      }

      var TYPE;
      (function (TYPE) {
        TYPE["SUCCESS"] = "success";
        TYPE["ERROR"] = "error";
        TYPE["WARNING"] = "warning";
        TYPE["INFO"] = "info";
        TYPE["DEFAULT"] = "default";
      })(TYPE || (TYPE = {}));
      var POSITION;
      (function (POSITION) {
        POSITION["TOP_LEFT"] = "top-left";
        POSITION["TOP_CENTER"] = "top-center";
        POSITION["TOP_RIGHT"] = "top-right";
        POSITION["BOTTOM_LEFT"] = "bottom-left";
        POSITION["BOTTOM_CENTER"] = "bottom-center";
        POSITION["BOTTOM_RIGHT"] = "bottom-right";
      })(POSITION || (POSITION = {}));
      var EVENTS;
      (function (EVENTS) {
        EVENTS["ADD"] = "add";
        EVENTS["DISMISS"] = "dismiss";
        EVENTS["UPDATE"] = "update";
        EVENTS["CLEAR"] = "clear";
        EVENTS["UPDATE_DEFAULTS"] = "update_defaults";
      })(EVENTS || (EVENTS = {}));
      const VT_NAMESPACE = "Vue-Toastification";

      const COMMON = {
        type: {
          type: String,
          default: TYPE.DEFAULT,
        },
        classNames: {
          type: [String, Array],
          default: () => [],
        },
        trueBoolean: {
          type: Boolean,
          default: true,
        },
      };
      const ICON = {
        type: COMMON.type,
        customIcon: {
          type: [String, Boolean, Object, Function],
          default: true,
        },
      };
      const CLOSE_BUTTON = {
        component: {
          type: [String, Object, Function, Boolean],
          default: "button",
        },
        classNames: COMMON.classNames,
        showOnHover: Boolean,
        ariaLabel: {
          type: String,
          default: "close",
        },
      };
      const PROGRESS_BAR = {
        timeout: {
          type: [Number, Boolean],
          default: 5000,
        },
        hideProgressBar: Boolean,
        isRunning: Boolean,
      };
      const TRANSITION = {
        transition: {
          type: [Object, String],
          default: `${VT_NAMESPACE}__bounce`,
        },
        transitionDuration: {
          type: [Number, Object],
          default: 750,
        },
      };
      const CORE_TOAST = {
        position: {
          type: String,
          default: POSITION.TOP_RIGHT,
        },
        draggable: COMMON.trueBoolean,
        draggablePercent: {
          type: Number,
          default: 0.6,
        },
        pauseOnFocusLoss: COMMON.trueBoolean,
        pauseOnHover: COMMON.trueBoolean,
        closeOnClick: COMMON.trueBoolean,
        timeout: PROGRESS_BAR.timeout,
        hideProgressBar: PROGRESS_BAR.hideProgressBar,
        toastClassName: COMMON.classNames,
        bodyClassName: COMMON.classNames,
        icon: ICON.customIcon,
        closeButton: CLOSE_BUTTON.component,
        closeButtonClassName: CLOSE_BUTTON.classNames,
        showCloseButtonOnHover: CLOSE_BUTTON.showOnHover,
        accessibility: {
          type: Object,
          default: () => ({
            toastRole: "alert",
            closeButtonLabel: "close",
          }),
        },
        rtl: Boolean,
        eventBus: Object,
      };
      const TOAST = {
        id: {
          type: [String, Number],
          required: true,
        },
        type: COMMON.type,
        content: {
          type: [String, Object, Function],
          required: true,
        },
        onClick: Function,
        onClose: Function,
      };
      const CONTAINER = {
        container: {
          type: undefined,
          default: () => document.body,
        },
        newestOnTop: COMMON.trueBoolean,
        maxToasts: {
          type: Number,
          default: 20,
        },
        transition: TRANSITION.transition,
        transitionDuration: TRANSITION.transitionDuration,
        toastDefaults: Object,
        filterBeforeCreate: {
          type: Function,
          default: (toast) => toast,
        },
        filterToasts: {
          type: Function,
          default: (toasts) => toasts,
        },
        containerClassName: COMMON.classNames,
        onMounted: Function,
      };
      var PROPS = {
        CORE_TOAST,
        TOAST,
        CONTAINER,
        PROGRESS_BAR,
        ICON,
        TRANSITION,
        CLOSE_BUTTON,
      };

// eslint-disable-next-line @typescript-eslint/ban-types
      const isFunction = (value) => typeof value === "function";
      const isString = (value) => typeof value === "string";
      const isNonEmptyString = (value) => isString(value) && value.trim().length > 0;
      const isNumber = (value) => typeof value === "number";
      const isUndefined = (value) => typeof value === "undefined";
      const isObject = (value) => typeof value === "object" && value !== null;
      const isJSX = (obj) => hasProp(obj, "tag") && isNonEmptyString(obj.tag);
      const isTouchEvent = (event) => window.TouchEvent && event instanceof TouchEvent;
      const isToastComponent = (obj) => hasProp(obj, "component") && isToastContent(obj.component);
      const isConstructor = (c) => {
        return isFunction(c) && hasProp(c, "cid");
      };
      const isVueComponent = (c) => {
        if (isConstructor(c)) {
          return true;
        }
        if (!isObject(c)) {
          return false;
        }
        if (c.extends || c._Ctor) {
          return true;
        }
        if (isString(c.template)) {
          return true;
        }
        return hasRenderFunction(c);
      };
      const isVueInstanceOrComponent = (obj) => obj instanceof vue__WEBPACK_IMPORTED_MODULE_0__["default"] || isVueComponent(obj);
      const isToastContent = (obj) =>
// Ignore undefined
          !isUndefined(obj) &&
          // Is a string
          (isString(obj) ||
              // Regular Vue instance or component
              isVueInstanceOrComponent(obj) ||
              // Object with a render function
              hasRenderFunction(obj) ||
              // JSX template
              isJSX(obj) ||
              // Nested object
              isToastComponent(obj));
      const isDOMRect = (obj) => isObject(obj) &&
          isNumber(obj.height) &&
          isNumber(obj.width) &&
          isNumber(obj.right) &&
          isNumber(obj.left) &&
          isNumber(obj.top) &&
          isNumber(obj.bottom);
      const hasProp = (obj, propKey) => Object.prototype.hasOwnProperty.call(obj, propKey);
      const hasRenderFunction = (obj
                                 // eslint-disable-next-line @typescript-eslint/ban-types
      ) => hasProp(obj, "render") && isFunction(obj.render);
      /**
       * ID generator
       */
      const getId = ((i) => () => i++)(0);
      function getX(event) {
        return isTouchEvent(event) ? event.targetTouches[0].clientX : event.clientX;
      }
      function getY(event) {
        return isTouchEvent(event) ? event.targetTouches[0].clientY : event.clientY;
      }
      const removeElement = (el) => {
        if (!isUndefined(el.remove)) {
          el.remove();
        }
        else if (el.parentNode) {
          el.parentNode.removeChild(el);
        }
      };
      const getVueComponentFromObj = (obj) => {
        if (isToastComponent(obj)) {
          // Recurse if component prop
          return getVueComponentFromObj(obj.component);
        }
        if (isJSX(obj)) {
          // Create render function for JSX
          return {
            render() {
              return obj;
            },
          };
        }
        // Return the actual object if regular vue component
        return obj;
      };

      var script = vue__WEBPACK_IMPORTED_MODULE_0__["default"].extend({
        props: PROPS.PROGRESS_BAR,
        data() {
          return {
            hasClass: true,
          };
        },
        computed: {
          style() {
            return {
              animationDuration: `${this.timeout}ms`,
              animationPlayState: this.isRunning ? "running" : "paused",
              opacity: this.hideProgressBar ? 0 : 1,
            };
          },
          cpClass() {
            return this.hasClass ? `${VT_NAMESPACE}__progress-bar` : "";
          },
        },
        mounted() {
          this.$el.addEventListener("animationend", this.animationEnded);
        },
        beforeDestroy() {
          this.$el.removeEventListener("animationend", this.animationEnded);
        },
        methods: {
          animationEnded() {
            this.$emit("close-toast");
          },
        },
        watch: {
          timeout() {
            this.hasClass = false;
            this.$nextTick(() => (this.hasClass = true));
          },
        },
      });

      function normalizeComponent(template, style, script, scopeId, isFunctionalTemplate, moduleIdentifier /* server only */, shadowMode, createInjector, createInjectorSSR, createInjectorShadow) {
        if (typeof shadowMode !== 'boolean') {
          createInjectorSSR = createInjector;
          createInjector = shadowMode;
          shadowMode = false;
        }
        // Vue.extend constructor export interop.
        const options = typeof script === 'function' ? script.options : script;
        // render functions
        if (template && template.render) {
          options.render = template.render;
          options.staticRenderFns = template.staticRenderFns;
          options._compiled = true;
          // functional template
          if (isFunctionalTemplate) {
            options.functional = true;
          }
        }
        // scopedId
        if (scopeId) {
          options._scopeId = scopeId;
        }
        let hook;
        if (moduleIdentifier) {
          // server build
          hook = function (context) {
            // 2.3 injection
            context =
                context || // cached call
                (this.$vnode && this.$vnode.ssrContext) || // stateful
                (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext); // functional
            // 2.2 with runInNewContext: true
            if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
              context = __VUE_SSR_CONTEXT__;
            }
            // inject component styles
            if (style) {
              style.call(this, createInjectorSSR(context));
            }
            // register component module identifier for async chunk inference
            if (context && context._registeredComponents) {
              context._registeredComponents.add(moduleIdentifier);
            }
          };
          // used by ssr in case component is cached and beforeCreate
          // never gets called
          options._ssrRegister = hook;
        }
        else if (style) {
          hook = shadowMode
              ? function (context) {
                style.call(this, createInjectorShadow(context, this.$root.$options.shadowRoot));
              }
              : function (context) {
                style.call(this, createInjector(context));
              };
        }
        if (hook) {
          if (options.functional) {
            // register for functional component in vue file
            const originalRender = options.render;
            options.render = function renderWithStyleInjection(h, context) {
              hook.call(context);
              return originalRender(h, context);
            };
          }
          else {
            // inject component registration as beforeCreate hook
            const existing = options.beforeCreate;
            options.beforeCreate = existing ? [].concat(existing, hook) : [hook];
          }
        }
        return script;
      }

      /* script */
      const __vue_script__ = script;

      /* template */
      var __vue_render__ = function() {
        var _vm = this;
        var _h = _vm.$createElement;
        var _c = _vm._self._c || _h;
        return _c("div", { class: _vm.cpClass, style: _vm.style })
      };
      var __vue_staticRenderFns__ = [];
      __vue_render__._withStripped = true;

      /* style */
      const __vue_inject_styles__ = undefined;
      /* scoped */
      const __vue_scope_id__ = undefined;
      /* module identifier */
      const __vue_module_identifier__ = undefined;
      /* functional template */
      const __vue_is_functional_template__ = false;
      /* style inject */

      /* style inject SSR */

      /* style inject shadow dom */



      const __vue_component__ = /*#__PURE__*/normalizeComponent(
          { render: __vue_render__, staticRenderFns: __vue_staticRenderFns__ },
          __vue_inject_styles__,
          __vue_script__,
          __vue_scope_id__,
          __vue_is_functional_template__,
          __vue_module_identifier__,
          false,
          undefined,
          undefined,
          undefined
      );

      var script$1 = vue__WEBPACK_IMPORTED_MODULE_0__["default"].extend({
        props: PROPS.CLOSE_BUTTON,
        computed: {
          buttonComponent() {
            if (this.component !== false) {
              return getVueComponentFromObj(this.component);
            }
            return "button";
          },
          classes() {
            const classes = [`${VT_NAMESPACE}__close-button`];
            if (this.showOnHover) {
              classes.push("show-on-hover");
            }
            return classes.concat(this.classNames);
          },
        },
      });

      /* script */
      const __vue_script__$1 = script$1;

      /* template */
      var __vue_render__$1 = function() {
        var _vm = this;
        var _h = _vm.$createElement;
        var _c = _vm._self._c || _h;
        return _c(
            _vm.buttonComponent,
            _vm._g(
                {
                  tag: "component",
                  class: _vm.classes,
                  attrs: { "aria-label": _vm.ariaLabel }
                },
                _vm.$listeners
            ),
            [_vm._v("\n  ×\n")]
        )
      };
      var __vue_staticRenderFns__$1 = [];
      __vue_render__$1._withStripped = true;

      /* style */
      const __vue_inject_styles__$1 = undefined;
      /* scoped */
      const __vue_scope_id__$1 = undefined;
      /* module identifier */
      const __vue_module_identifier__$1 = undefined;
      /* functional template */
      const __vue_is_functional_template__$1 = false;
      /* style inject */

      /* style inject SSR */

      /* style inject shadow dom */



      const __vue_component__$1 = /*#__PURE__*/normalizeComponent(
          { render: __vue_render__$1, staticRenderFns: __vue_staticRenderFns__$1 },
          __vue_inject_styles__$1,
          __vue_script__$1,
          __vue_scope_id__$1,
          __vue_is_functional_template__$1,
          __vue_module_identifier__$1,
          false,
          undefined,
          undefined,
          undefined
      );

      var script$2 = {};

      /* script */
      const __vue_script__$2 = script$2;

      /* template */
      var __vue_render__$2 = function() {
        var _vm = this;
        var _h = _vm.$createElement;
        var _c = _vm._self._c || _h;
        return _c(
            "svg",
            {
              staticClass: "svg-inline--fa fa-check-circle fa-w-16",
              attrs: {
                "aria-hidden": "true",
                focusable: "false",
                "data-prefix": "fas",
                "data-icon": "check-circle",
                role: "img",
                xmlns: "http://www.w3.org/2000/svg",
                viewBox: "0 0 512 512"
              }
            },
            [
              _c("path", {
                attrs: {
                  fill: "currentColor",
                  d:
                      "M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z"
                }
              })
            ]
        )
      };
      var __vue_staticRenderFns__$2 = [];
      __vue_render__$2._withStripped = true;

      /* style */
      const __vue_inject_styles__$2 = undefined;
      /* scoped */
      const __vue_scope_id__$2 = undefined;
      /* module identifier */
      const __vue_module_identifier__$2 = undefined;
      /* functional template */
      const __vue_is_functional_template__$2 = false;
      /* style inject */

      /* style inject SSR */

      /* style inject shadow dom */



      const __vue_component__$2 = /*#__PURE__*/normalizeComponent(
          { render: __vue_render__$2, staticRenderFns: __vue_staticRenderFns__$2 },
          __vue_inject_styles__$2,
          __vue_script__$2,
          __vue_scope_id__$2,
          __vue_is_functional_template__$2,
          __vue_module_identifier__$2,
          false,
          undefined,
          undefined,
          undefined
      );

      var script$3 = {};

      /* script */
      const __vue_script__$3 = script$3;

      /* template */
      var __vue_render__$3 = function() {
        var _vm = this;
        var _h = _vm.$createElement;
        var _c = _vm._self._c || _h;
        return _c(
            "svg",
            {
              staticClass: "svg-inline--fa fa-info-circle fa-w-16",
              attrs: {
                "aria-hidden": "true",
                focusable: "false",
                "data-prefix": "fas",
                "data-icon": "info-circle",
                role: "img",
                xmlns: "http://www.w3.org/2000/svg",
                viewBox: "0 0 512 512"
              }
            },
            [
              _c("path", {
                attrs: {
                  fill: "currentColor",
                  d:
                      "M256 8C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm0 110c23.196 0 42 18.804 42 42s-18.804 42-42 42-42-18.804-42-42 18.804-42 42-42zm56 254c0 6.627-5.373 12-12 12h-88c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h12v-64h-12c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h64c6.627 0 12 5.373 12 12v100h12c6.627 0 12 5.373 12 12v24z"
                }
              })
            ]
        )
      };
      var __vue_staticRenderFns__$3 = [];
      __vue_render__$3._withStripped = true;

      /* style */
      const __vue_inject_styles__$3 = undefined;
      /* scoped */
      const __vue_scope_id__$3 = undefined;
      /* module identifier */
      const __vue_module_identifier__$3 = undefined;
      /* functional template */
      const __vue_is_functional_template__$3 = false;
      /* style inject */

      /* style inject SSR */

      /* style inject shadow dom */



      const __vue_component__$3 = /*#__PURE__*/normalizeComponent(
          { render: __vue_render__$3, staticRenderFns: __vue_staticRenderFns__$3 },
          __vue_inject_styles__$3,
          __vue_script__$3,
          __vue_scope_id__$3,
          __vue_is_functional_template__$3,
          __vue_module_identifier__$3,
          false,
          undefined,
          undefined,
          undefined
      );

      var script$4 = {};

      /* script */
      const __vue_script__$4 = script$4;

      /* template */
      var __vue_render__$4 = function() {
        var _vm = this;
        var _h = _vm.$createElement;
        var _c = _vm._self._c || _h;
        return _c(
            "svg",
            {
              staticClass: "svg-inline--fa fa-exclamation-circle fa-w-16",
              attrs: {
                "aria-hidden": "true",
                focusable: "false",
                "data-prefix": "fas",
                "data-icon": "exclamation-circle",
                role: "img",
                xmlns: "http://www.w3.org/2000/svg",
                viewBox: "0 0 512 512"
              }
            },
            [
              _c("path", {
                attrs: {
                  fill: "currentColor",
                  d:
                      "M504 256c0 136.997-111.043 248-248 248S8 392.997 8 256C8 119.083 119.043 8 256 8s248 111.083 248 248zm-248 50c-25.405 0-46 20.595-46 46s20.595 46 46 46 46-20.595 46-46-20.595-46-46-46zm-43.673-165.346l7.418 136c.347 6.364 5.609 11.346 11.982 11.346h48.546c6.373 0 11.635-4.982 11.982-11.346l7.418-136c.375-6.874-5.098-12.654-11.982-12.654h-63.383c-6.884 0-12.356 5.78-11.981 12.654z"
                }
              })
            ]
        )
      };
      var __vue_staticRenderFns__$4 = [];
      __vue_render__$4._withStripped = true;

      /* style */
      const __vue_inject_styles__$4 = undefined;
      /* scoped */
      const __vue_scope_id__$4 = undefined;
      /* module identifier */
      const __vue_module_identifier__$4 = undefined;
      /* functional template */
      const __vue_is_functional_template__$4 = false;
      /* style inject */

      /* style inject SSR */

      /* style inject shadow dom */



      const __vue_component__$4 = /*#__PURE__*/normalizeComponent(
          { render: __vue_render__$4, staticRenderFns: __vue_staticRenderFns__$4 },
          __vue_inject_styles__$4,
          __vue_script__$4,
          __vue_scope_id__$4,
          __vue_is_functional_template__$4,
          __vue_module_identifier__$4,
          false,
          undefined,
          undefined,
          undefined
      );

      var script$5 = {};

      /* script */
      const __vue_script__$5 = script$5;

      /* template */
      var __vue_render__$5 = function() {
        var _vm = this;
        var _h = _vm.$createElement;
        var _c = _vm._self._c || _h;
        return _c(
            "svg",
            {
              staticClass: "svg-inline--fa fa-exclamation-triangle fa-w-18",
              attrs: {
                "aria-hidden": "true",
                focusable: "false",
                "data-prefix": "fas",
                "data-icon": "exclamation-triangle",
                role: "img",
                xmlns: "http://www.w3.org/2000/svg",
                viewBox: "0 0 576 512"
              }
            },
            [
              _c("path", {
                attrs: {
                  fill: "currentColor",
                  d:
                      "M569.517 440.013C587.975 472.007 564.806 512 527.94 512H48.054c-36.937 0-59.999-40.055-41.577-71.987L246.423 23.985c18.467-32.009 64.72-31.951 83.154 0l239.94 416.028zM288 354c-25.405 0-46 20.595-46 46s20.595 46 46 46 46-20.595 46-46-20.595-46-46-46zm-43.673-165.346l7.418 136c.347 6.364 5.609 11.346 11.982 11.346h48.546c6.373 0 11.635-4.982 11.982-11.346l7.418-136c.375-6.874-5.098-12.654-11.982-12.654h-63.383c-6.884 0-12.356 5.78-11.981 12.654z"
                }
              })
            ]
        )
      };
      var __vue_staticRenderFns__$5 = [];
      __vue_render__$5._withStripped = true;

      /* style */
      const __vue_inject_styles__$5 = undefined;
      /* scoped */
      const __vue_scope_id__$5 = undefined;
      /* module identifier */
      const __vue_module_identifier__$5 = undefined;
      /* functional template */
      const __vue_is_functional_template__$5 = false;
      /* style inject */

      /* style inject SSR */

      /* style inject shadow dom */



      const __vue_component__$5 = /*#__PURE__*/normalizeComponent(
          { render: __vue_render__$5, staticRenderFns: __vue_staticRenderFns__$5 },
          __vue_inject_styles__$5,
          __vue_script__$5,
          __vue_scope_id__$5,
          __vue_is_functional_template__$5,
          __vue_module_identifier__$5,
          false,
          undefined,
          undefined,
          undefined
      );

      var script$6 = vue__WEBPACK_IMPORTED_MODULE_0__["default"].extend({
        props: PROPS.ICON,
        computed: {
          customIconChildren() {
            return hasProp(this.customIcon, "iconChildren")
                ? this.trimValue(this.customIcon.iconChildren)
                : "";
          },
          customIconClass() {
            if (isString(this.customIcon)) {
              return this.trimValue(this.customIcon);
            }
            else if (hasProp(this.customIcon, "iconClass")) {
              return this.trimValue(this.customIcon.iconClass);
            }
            return "";
          },
          customIconTag() {
            if (hasProp(this.customIcon, "iconTag")) {
              return this.trimValue(this.customIcon.iconTag, "i");
            }
            return "i";
          },
          hasCustomIcon() {
            return this.customIconClass.length > 0;
          },
          component() {
            if (this.hasCustomIcon) {
              return this.customIconTag;
            }
            if (isToastContent(this.customIcon)) {
              return getVueComponentFromObj(this.customIcon);
            }
            return this.iconTypeComponent;
          },
          iconTypeComponent() {
            const types = {
              [TYPE.DEFAULT]: __vue_component__$3,
              [TYPE.INFO]: __vue_component__$3,
              [TYPE.SUCCESS]: __vue_component__$2,
              [TYPE.ERROR]: __vue_component__$5,
              [TYPE.WARNING]: __vue_component__$4,
            };
            return types[this.type];
          },
          iconClasses() {
            const classes = [`${VT_NAMESPACE}__icon`];
            if (this.hasCustomIcon) {
              return classes.concat(this.customIconClass);
            }
            return classes;
          },
        },
        methods: {
          trimValue(value, empty = "") {
            return isNonEmptyString(value) ? value.trim() : empty;
          },
        },
      });

      /* script */
      const __vue_script__$6 = script$6;

      /* template */
      var __vue_render__$6 = function() {
        var _vm = this;
        var _h = _vm.$createElement;
        var _c = _vm._self._c || _h;
        return _c(_vm.component, { tag: "component", class: _vm.iconClasses }, [
          _vm._v(_vm._s(_vm.customIconChildren))
        ])
      };
      var __vue_staticRenderFns__$6 = [];
      __vue_render__$6._withStripped = true;

      /* style */
      const __vue_inject_styles__$6 = undefined;
      /* scoped */
      const __vue_scope_id__$6 = undefined;
      /* module identifier */
      const __vue_module_identifier__$6 = undefined;
      /* functional template */
      const __vue_is_functional_template__$6 = false;
      /* style inject */

      /* style inject SSR */

      /* style inject shadow dom */



      const __vue_component__$6 = /*#__PURE__*/normalizeComponent(
          { render: __vue_render__$6, staticRenderFns: __vue_staticRenderFns__$6 },
          __vue_inject_styles__$6,
          __vue_script__$6,
          __vue_scope_id__$6,
          __vue_is_functional_template__$6,
          __vue_module_identifier__$6,
          false,
          undefined,
          undefined,
          undefined
      );

      var script$7 = vue__WEBPACK_IMPORTED_MODULE_0__["default"].extend({
        components: { ProgressBar: __vue_component__, CloseButton: __vue_component__$1, Icon: __vue_component__$6 },
        inheritAttrs: false,
        props: Object.assign({}, PROPS.CORE_TOAST, PROPS.TOAST),
        data() {
          const data = {
            isRunning: true,
            disableTransitions: false,
            beingDragged: false,
            dragStart: 0,
            dragPos: { x: 0, y: 0 },
            dragRect: {},
          };
          return data;
        },
        computed: {
          classes() {
            const classes = [
              `${VT_NAMESPACE}__toast`,
              `${VT_NAMESPACE}__toast--${this.type}`,
              `${this.position}`,
            ].concat(this.toastClassName);
            if (this.disableTransitions) {
              classes.push("disable-transition");
            }
            if (this.rtl) {
              classes.push(`${VT_NAMESPACE}__toast--rtl`);
            }
            return classes;
          },
          bodyClasses() {
            const classes = [
              `${VT_NAMESPACE}__toast-${isString(this.content) ? "body" : "component-body"}`,
            ].concat(this.bodyClassName);
            return classes;
          },
          draggableStyle() {
            if (this.dragStart === this.dragPos.x) {
              return {};
            }
            if (this.beingDragged) {
              return {
                transform: `translateX(${this.dragDelta}px)`,
                opacity: 1 - Math.abs(this.dragDelta / this.removalDistance),
              };
            }
            return {
              transition: "transform 0.2s, opacity 0.2s",
              transform: "translateX(0)",
              opacity: 1,
            };
          },
          dragDelta() {
            return this.beingDragged ? this.dragPos.x - this.dragStart : 0;
          },
          removalDistance() {
            if (isDOMRect(this.dragRect)) {
              return ((this.dragRect.right - this.dragRect.left) * this.draggablePercent);
            }
            return 0;
          },
        },
        mounted() {
          if (this.draggable) {
            this.draggableSetup();
          }
          if (this.pauseOnFocusLoss) {
            this.focusSetup();
          }
        },
        beforeDestroy() {
          if (this.draggable) {
            this.draggableCleanup();
          }
          if (this.pauseOnFocusLoss) {
            this.focusCleanup();
          }
        },
        destroyed() {
          setTimeout(() => {
            removeElement(this.$el);
          }, 1000);
        },
        methods: {
          getVueComponentFromObj,
          closeToast() {
            this.eventBus.$emit(EVENTS.DISMISS, this.id);
          },
          clickHandler() {
            if (this.onClick) {
              this.onClick(this.closeToast);
            }
            if (this.closeOnClick) {
              if (!this.beingDragged || this.dragStart === this.dragPos.x) {
                this.closeToast();
              }
            }
          },
          timeoutHandler() {
            this.closeToast();
          },
          hoverPause() {
            if (this.pauseOnHover) {
              this.isRunning = false;
            }
          },
          hoverPlay() {
            if (this.pauseOnHover) {
              this.isRunning = true;
            }
          },
          focusPause() {
            this.isRunning = false;
          },
          focusPlay() {
            this.isRunning = true;
          },
          focusSetup() {
            addEventListener("blur", this.focusPause);
            addEventListener("focus", this.focusPlay);
          },
          focusCleanup() {
            removeEventListener("blur", this.focusPause);
            removeEventListener("focus", this.focusPlay);
          },
          draggableSetup() {
            const element = this.$el;
            element.addEventListener("touchstart", this.onDragStart, {
              passive: true,
            });
            element.addEventListener("mousedown", this.onDragStart);
            addEventListener("touchmove", this.onDragMove, { passive: false });
            addEventListener("mousemove", this.onDragMove);
            addEventListener("touchend", this.onDragEnd);
            addEventListener("mouseup", this.onDragEnd);
          },
          draggableCleanup() {
            const element = this.$el;
            element.removeEventListener("touchstart", this.onDragStart);
            element.removeEventListener("mousedown", this.onDragStart);
            removeEventListener("touchmove", this.onDragMove);
            removeEventListener("mousemove", this.onDragMove);
            removeEventListener("touchend", this.onDragEnd);
            removeEventListener("mouseup", this.onDragEnd);
          },
          onDragStart(event) {
            this.beingDragged = true;
            this.dragPos = { x: getX(event), y: getY(event) };
            this.dragStart = getX(event);
            this.dragRect = this.$el.getBoundingClientRect();
          },
          onDragMove(event) {
            if (this.beingDragged) {
              event.preventDefault();
              if (this.isRunning) {
                this.isRunning = false;
              }
              this.dragPos = { x: getX(event), y: getY(event) };
            }
          },
          onDragEnd() {
            if (this.beingDragged) {
              if (Math.abs(this.dragDelta) >= this.removalDistance) {
                this.disableTransitions = true;
                this.$nextTick(() => this.closeToast());
              }
              else {
                setTimeout(() => {
                  this.beingDragged = false;
                  if (isDOMRect(this.dragRect) &&
                      this.pauseOnHover &&
                      this.dragRect.bottom >= this.dragPos.y &&
                      this.dragPos.y >= this.dragRect.top &&
                      this.dragRect.left <= this.dragPos.x &&
                      this.dragPos.x <= this.dragRect.right) {
                    this.isRunning = false;
                  }
                  else {
                    this.isRunning = true;
                  }
                });
              }
            }
          },
        },
      });

      /* script */
      const __vue_script__$7 = script$7;

      /* template */
      var __vue_render__$7 = function() {
        var _vm = this;
        var _h = _vm.$createElement;
        var _c = _vm._self._c || _h;
        return _c(
            "div",
            {
              class: _vm.classes,
              style: _vm.draggableStyle,
              on: {
                click: _vm.clickHandler,
                mouseenter: _vm.hoverPause,
                mouseleave: _vm.hoverPlay
              }
            },
            [
              _vm.icon
                  ? _c("Icon", { attrs: { "custom-icon": _vm.icon, type: _vm.type } })
                  : _vm._e(),
              _vm._v(" "),
              _c(
                  "div",
                  {
                    class: _vm.bodyClasses,
                    attrs: { role: _vm.accessibility.toastRole || "alert" }
                  },
                  [
                    typeof _vm.content === "string"
                        ? [_vm._v(_vm._s(_vm.content))]
                        : _c(
                        _vm.getVueComponentFromObj(_vm.content),
                        _vm._g(
                            _vm._b(
                                {
                                  tag: "component",
                                  attrs: { "toast-id": _vm.id },
                                  on: { "close-toast": _vm.closeToast }
                                },
                                "component",
                                _vm.content.props,
                                false
                            ),
                            _vm.content.listeners
                        )
                        )
                  ],
                  2
              ),
              _vm._v(" "),
              !!_vm.closeButton
                  ? _c("CloseButton", {
                    attrs: {
                      component: _vm.closeButton,
                      "class-names": _vm.closeButtonClassName,
                      "show-on-hover": _vm.showCloseButtonOnHover,
                      "aria-label": _vm.accessibility.closeButtonLabel
                    },
                    on: {
                      click: function($event) {
                        $event.stopPropagation();
                        return _vm.closeToast($event)
                      }
                    }
                  })
                  : _vm._e(),
              _vm._v(" "),
              _vm.timeout
                  ? _c("ProgressBar", {
                    attrs: {
                      "is-running": _vm.isRunning,
                      "hide-progress-bar": _vm.hideProgressBar,
                      timeout: _vm.timeout
                    },
                    on: { "close-toast": _vm.timeoutHandler }
                  })
                  : _vm._e()
            ],
            1
        )
      };
      var __vue_staticRenderFns__$7 = [];
      __vue_render__$7._withStripped = true;

      /* style */
      const __vue_inject_styles__$7 = undefined;
      /* scoped */
      const __vue_scope_id__$7 = undefined;
      /* module identifier */
      const __vue_module_identifier__$7 = undefined;
      /* functional template */
      const __vue_is_functional_template__$7 = false;
      /* style inject */

      /* style inject SSR */

      /* style inject shadow dom */



      const __vue_component__$7 = /*#__PURE__*/normalizeComponent(
          { render: __vue_render__$7, staticRenderFns: __vue_staticRenderFns__$7 },
          __vue_inject_styles__$7,
          __vue_script__$7,
          __vue_scope_id__$7,
          __vue_is_functional_template__$7,
          __vue_module_identifier__$7,
          false,
          undefined,
          undefined,
          undefined
      );

// Transition methods taken from https://github.com/BinarCode/vue2-transitions
      var script$8 = vue__WEBPACK_IMPORTED_MODULE_0__["default"].extend({
        inheritAttrs: false,
        props: PROPS.TRANSITION,
        methods: {
          beforeEnter(el) {
            const enterDuration = typeof this.transitionDuration === "number"
                ? this.transitionDuration
                : this.transitionDuration.enter;
            el.style.animationDuration = `${enterDuration}ms`;
            el.style.animationFillMode = "both";
            this.$emit("before-enter", el);
          },
          afterEnter(el) {
            this.cleanUpStyles(el);
            this.$emit("after-enter", el);
          },
          afterLeave(el) {
            this.cleanUpStyles(el);
            this.$emit("after-leave", el);
          },
          beforeLeave(el) {
            const leaveDuration = typeof this.transitionDuration === "number"
                ? this.transitionDuration
                : this.transitionDuration.leave;
            el.style.animationDuration = `${leaveDuration}ms`;
            el.style.animationFillMode = "both";
            this.$emit("before-leave", el);
          },
          // eslint-disable-next-line @typescript-eslint/ban-types
          leave(el, done) {
            this.setAbsolutePosition(el);
            this.$emit("leave", el, done);
          },
          setAbsolutePosition(el) {
            el.style.left = el.offsetLeft + "px";
            el.style.top = el.offsetTop + "px";
            el.style.width = getComputedStyle(el).width;
            el.style.height = getComputedStyle(el).height;
            el.style.position = "absolute";
          },
          cleanUpStyles(el) {
            el.style.animationFillMode = "";
            el.style.animationDuration = "";
          },
        },
      });

      /* script */
      const __vue_script__$8 = script$8;

      /* template */
      var __vue_render__$8 = function() {
        var _vm = this;
        var _h = _vm.$createElement;
        var _c = _vm._self._c || _h;
        return _c(
            "transition-group",
            {
              attrs: {
                tag: "div",
                "enter-active-class": _vm.transition.enter
                    ? _vm.transition.enter
                    : _vm.transition + "-enter-active",
                "move-class": _vm.transition.move
                    ? _vm.transition.move
                    : _vm.transition + "-move",
                "leave-active-class": _vm.transition.leave
                    ? _vm.transition.leave
                    : _vm.transition + "-leave-active"
              },
              on: {
                leave: _vm.leave,
                "before-enter": _vm.beforeEnter,
                "before-leave": _vm.beforeLeave,
                "after-enter": _vm.afterEnter,
                "after-leave": _vm.afterLeave
              }
            },
            [_vm._t("default")],
            2
        )
      };
      var __vue_staticRenderFns__$8 = [];
      __vue_render__$8._withStripped = true;

      /* style */
      const __vue_inject_styles__$8 = undefined;
      /* scoped */
      const __vue_scope_id__$8 = undefined;
      /* module identifier */
      const __vue_module_identifier__$8 = undefined;
      /* functional template */
      const __vue_is_functional_template__$8 = false;
      /* style inject */

      /* style inject SSR */

      /* style inject shadow dom */



      const __vue_component__$8 = /*#__PURE__*/normalizeComponent(
          { render: __vue_render__$8, staticRenderFns: __vue_staticRenderFns__$8 },
          __vue_inject_styles__$8,
          __vue_script__$8,
          __vue_scope_id__$8,
          __vue_is_functional_template__$8,
          __vue_module_identifier__$8,
          false,
          undefined,
          undefined,
          undefined
      );

      var script$9 = vue__WEBPACK_IMPORTED_MODULE_0__["default"].extend({
        components: { Toast: __vue_component__$7, VtTransition: __vue_component__$8 },
        props: Object.assign({}, PROPS.CORE_TOAST, PROPS.CONTAINER, PROPS.TRANSITION),
        data() {
          const data = {
            count: 0,
            positions: Object.values(POSITION),
            toasts: {},
            defaults: {},
          };
          return data;
        },
        computed: {
          toastArray() {
            return Object.values(this.toasts);
          },
          filteredToasts() {
            return this.defaults.filterToasts(this.toastArray);
          },
        },
        beforeMount() {
          this.setup(this.container);
          const events = this.eventBus;
          events.$on(EVENTS.ADD, this.addToast);
          events.$on(EVENTS.CLEAR, this.clearToasts);
          events.$on(EVENTS.DISMISS, this.dismissToast);
          events.$on(EVENTS.UPDATE, this.updateToast);
          events.$on(EVENTS.UPDATE_DEFAULTS, this.updateDefaults);
          this.defaults = this.$props;
        },
        methods: {
          setup(container) {
            return __awaiter(this, void 0, void 0, function* () {
              if (isFunction(container)) {
                container = yield container();
              }
              removeElement(this.$el);
              container.appendChild(this.$el);
            });
          },
          setToast(props) {
            if (!isUndefined(props.id)) {
              this.$set(this.toasts, props.id, props);
            }
          },
          addToast(params) {
            const props = Object.assign({}, this.defaults, params.type &&
                this.defaults.toastDefaults &&
                this.defaults.toastDefaults[params.type], params);
            const toast = this.defaults.filterBeforeCreate(props, this.toastArray);
            toast && this.setToast(toast);
          },
          dismissToast(id) {
            const toast = this.toasts[id];
            if (!isUndefined(toast) && !isUndefined(toast.onClose)) {
              toast.onClose();
            }
            this.$delete(this.toasts, id);
          },
          clearToasts() {
            Object.keys(this.toasts).forEach((id) => {
              this.dismissToast(id);
            });
          },
          getPositionToasts(position) {
            const toasts = this.filteredToasts
                .filter((toast) => toast.position === position)
                .slice(0, this.defaults.maxToasts);
            return this.defaults.newestOnTop ? toasts.reverse() : toasts;
          },
          updateDefaults(update) {
            // Update container if changed
            if (!isUndefined(update.container)) {
              this.setup(update.container);
            }
            this.defaults = Object.assign({}, this.defaults, update);
          },
          updateToast({ id, options, create, }) {
            if (this.toasts[id]) {
              // If a timeout is defined, and is equal to the one before, change it
              // a little so the progressBar is reset
              if (options.timeout && options.timeout === this.toasts[id].timeout) {
                options.timeout++;
              }
              this.setToast(Object.assign({}, this.toasts[id], options));
            }
            else if (create) {
              this.addToast(Object.assign({}, { id }, options));
            }
          },
          getClasses(position) {
            const classes = [`${VT_NAMESPACE}__container`, position];
            return classes.concat(this.defaults.containerClassName);
          },
        },
      });

      /* script */
      const __vue_script__$9 = script$9;

      /* template */
      var __vue_render__$9 = function() {
        var _vm = this;
        var _h = _vm.$createElement;
        var _c = _vm._self._c || _h;
        return _c(
            "div",
            _vm._l(_vm.positions, function(pos) {
              return _c(
                  "div",
                  { key: pos },
                  [
                    _c(
                        "VtTransition",
                        {
                          class: _vm.getClasses(pos),
                          attrs: {
                            transition: _vm.defaults.transition,
                            "transition-duration": _vm.defaults.transitionDuration
                          }
                        },
                        _vm._l(_vm.getPositionToasts(pos), function(toast) {
                          return _c(
                              "Toast",
                              _vm._b({ key: toast.id }, "Toast", toast, false)
                          )
                        }),
                        1
                    )
                  ],
                  1
              )
            }),
            0
        )
      };
      var __vue_staticRenderFns__$9 = [];
      __vue_render__$9._withStripped = true;

      /* style */
      const __vue_inject_styles__$9 = undefined;
      /* scoped */
      const __vue_scope_id__$9 = undefined;
      /* module identifier */
      const __vue_module_identifier__$9 = undefined;
      /* functional template */
      const __vue_is_functional_template__$9 = false;
      /* style inject */

      /* style inject SSR */

      /* style inject shadow dom */



      const __vue_component__$9 = /*#__PURE__*/normalizeComponent(
          { render: __vue_render__$9, staticRenderFns: __vue_staticRenderFns__$9 },
          __vue_inject_styles__$9,
          __vue_script__$9,
          __vue_scope_id__$9,
          __vue_is_functional_template__$9,
          __vue_module_identifier__$9,
          false,
          undefined,
          undefined,
          undefined
      );

      const ToastInterface = (Vue, globalOptions = {}, mountContainer = true) => {
        const events = (globalOptions.eventBus = globalOptions.eventBus || new Vue());
        if (mountContainer) {
          const containerComponent = new (Vue.extend(__vue_component__$9))({
            el: document.createElement("div"),
            propsData: globalOptions,
          });
          const onMounted = globalOptions.onMounted;
          if (!isUndefined(onMounted)) {
            onMounted(containerComponent);
          }
        }
        /**
         * Display a toast
         */
        const toast = (content, options) => {
          const props = Object.assign({}, { id: getId(), type: TYPE.DEFAULT }, options, {
            content,
          });
          events.$emit(EVENTS.ADD, props);
          return props.id;
        };
        /**
         * Clear all toasts
         */
        toast.clear = () => events.$emit(EVENTS.CLEAR);
        /**
         * Update Plugin Defaults
         */
        toast.updateDefaults = (update) => {
          events.$emit(EVENTS.UPDATE_DEFAULTS, update);
        };
        /**
         * Dismiss toast specified by an id
         */
        toast.dismiss = (id) => {
          events.$emit(EVENTS.DISMISS, id);
        };
        function updateToast(id, { content, options }, create = false) {
          events.$emit(EVENTS.UPDATE, {
            id,
            options: Object.assign({}, options, { content }),
            create,
          });
        }
        toast.update = updateToast;
        /**
         * Display a success toast
         */
        toast.success = (content, options) => toast(content, Object.assign({}, options, { type: TYPE.SUCCESS }));
        /**
         * Display an info toast
         */
        toast.info = (content, options) => toast(content, Object.assign({}, options, { type: TYPE.INFO }));
        /**
         * Display an error toast
         */
        toast.error = (content, options) => toast(content, Object.assign({}, options, { type: TYPE.ERROR }));
        /**
         * Display a warning toast
         */
        toast.warning = (content, options) => toast(content, Object.assign({}, options, { type: TYPE.WARNING }));
        return toast;
      };

      function createToastInterface(optionsOrEventBus, Vue$1 = vue__WEBPACK_IMPORTED_MODULE_0__["default"]) {
        const isVueInstance = (obj) => obj instanceof Vue$1;
        if (isVueInstance(optionsOrEventBus)) {
          return ToastInterface(Vue$1, { eventBus: optionsOrEventBus }, false);
        }
        return ToastInterface(Vue$1, optionsOrEventBus, true);
      }
      const VueToastificationPlugin = (Vue, options) => {
        const toast = createToastInterface(options, Vue);
        Vue.$toast = toast;
        Vue.prototype.$toast = toast;
      };

      /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (VueToastificationPlugin);

//# sourceMappingURL=index.js.map


      /***/ }),

    /***/ "./node_modules/vue/dist/vue.esm.js":
    /*!******************************************!*\
  !*** ./node_modules/vue/dist/vue.esm.js ***!
  \******************************************/
    /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

      "use strict";
      __webpack_require__.r(__webpack_exports__);
      /* harmony export */ __webpack_require__.d(__webpack_exports__, {
        /* harmony export */   "EffectScope": () => (/* binding */ EffectScope),
        /* harmony export */   "computed": () => (/* binding */ computed),
        /* harmony export */   "customRef": () => (/* binding */ customRef),
        /* harmony export */   "default": () => (/* binding */ Vue),
        /* harmony export */   "defineAsyncComponent": () => (/* binding */ defineAsyncComponent),
        /* harmony export */   "defineComponent": () => (/* binding */ defineComponent),
        /* harmony export */   "del": () => (/* binding */ del),
        /* harmony export */   "effectScope": () => (/* binding */ effectScope),
        /* harmony export */   "getCurrentInstance": () => (/* binding */ getCurrentInstance),
        /* harmony export */   "getCurrentScope": () => (/* binding */ getCurrentScope),
        /* harmony export */   "h": () => (/* binding */ h),
        /* harmony export */   "inject": () => (/* binding */ inject),
        /* harmony export */   "isProxy": () => (/* binding */ isProxy),
        /* harmony export */   "isReactive": () => (/* binding */ isReactive),
        /* harmony export */   "isReadonly": () => (/* binding */ isReadonly),
        /* harmony export */   "isRef": () => (/* binding */ isRef),
        /* harmony export */   "isShallow": () => (/* binding */ isShallow),
        /* harmony export */   "markRaw": () => (/* binding */ markRaw),
        /* harmony export */   "mergeDefaults": () => (/* binding */ mergeDefaults),
        /* harmony export */   "nextTick": () => (/* binding */ nextTick),
        /* harmony export */   "onActivated": () => (/* binding */ onActivated),
        /* harmony export */   "onBeforeMount": () => (/* binding */ onBeforeMount),
        /* harmony export */   "onBeforeUnmount": () => (/* binding */ onBeforeUnmount),
        /* harmony export */   "onBeforeUpdate": () => (/* binding */ onBeforeUpdate),
        /* harmony export */   "onDeactivated": () => (/* binding */ onDeactivated),
        /* harmony export */   "onErrorCaptured": () => (/* binding */ onErrorCaptured),
        /* harmony export */   "onMounted": () => (/* binding */ onMounted),
        /* harmony export */   "onRenderTracked": () => (/* binding */ onRenderTracked),
        /* harmony export */   "onRenderTriggered": () => (/* binding */ onRenderTriggered),
        /* harmony export */   "onScopeDispose": () => (/* binding */ onScopeDispose),
        /* harmony export */   "onServerPrefetch": () => (/* binding */ onServerPrefetch),
        /* harmony export */   "onUnmounted": () => (/* binding */ onUnmounted),
        /* harmony export */   "onUpdated": () => (/* binding */ onUpdated),
        /* harmony export */   "provide": () => (/* binding */ provide),
        /* harmony export */   "proxyRefs": () => (/* binding */ proxyRefs),
        /* harmony export */   "reactive": () => (/* binding */ reactive),
        /* harmony export */   "readonly": () => (/* binding */ readonly),
        /* harmony export */   "ref": () => (/* binding */ ref$1),
        /* harmony export */   "set": () => (/* binding */ set),
        /* harmony export */   "shallowReactive": () => (/* binding */ shallowReactive),
        /* harmony export */   "shallowReadonly": () => (/* binding */ shallowReadonly),
        /* harmony export */   "shallowRef": () => (/* binding */ shallowRef),
        /* harmony export */   "toRaw": () => (/* binding */ toRaw),
        /* harmony export */   "toRef": () => (/* binding */ toRef),
        /* harmony export */   "toRefs": () => (/* binding */ toRefs),
        /* harmony export */   "triggerRef": () => (/* binding */ triggerRef),
        /* harmony export */   "unref": () => (/* binding */ unref),
        /* harmony export */   "useAttrs": () => (/* binding */ useAttrs),
        /* harmony export */   "useCssModule": () => (/* binding */ useCssModule),
        /* harmony export */   "useCssVars": () => (/* binding */ useCssVars),
        /* harmony export */   "useListeners": () => (/* binding */ useListeners),
        /* harmony export */   "useSlots": () => (/* binding */ useSlots),
        /* harmony export */   "version": () => (/* binding */ version),
        /* harmony export */   "watch": () => (/* binding */ watch),
        /* harmony export */   "watchEffect": () => (/* binding */ watchEffect),
        /* harmony export */   "watchPostEffect": () => (/* binding */ watchPostEffect),
        /* harmony export */   "watchSyncEffect": () => (/* binding */ watchSyncEffect)
        /* harmony export */ });
      /*!
 * Vue.js v2.7.14
 * (c) 2014-2022 Evan You
 * Released under the MIT License.
 */
      var emptyObject = Object.freeze({});
      var isArray = Array.isArray;
// These helpers produce better VM code in JS engines due to their
// explicitness and function inlining.
      function isUndef(v) {
        return v === undefined || v === null;
      }
      function isDef(v) {
        return v !== undefined && v !== null;
      }
      function isTrue(v) {
        return v === true;
      }
      function isFalse(v) {
        return v === false;
      }
      /**
       * Check if value is primitive.
       */
      function isPrimitive(value) {
        return (typeof value === 'string' ||
            typeof value === 'number' ||
            // $flow-disable-line
            typeof value === 'symbol' ||
            typeof value === 'boolean');
      }
      function isFunction(value) {
        return typeof value === 'function';
      }
      /**
       * Quick object check - this is primarily used to tell
       * objects from primitive values when we know the value
       * is a JSON-compliant type.
       */
      function isObject(obj) {
        return obj !== null && typeof obj === 'object';
      }
      /**
       * Get the raw type string of a value, e.g., [object Object].
       */
      var _toString = Object.prototype.toString;
      function toRawType(value) {
        return _toString.call(value).slice(8, -1);
      }
      /**
       * Strict object type check. Only returns true
       * for plain JavaScript objects.
       */
      function isPlainObject(obj) {
        return _toString.call(obj) === '[object Object]';
      }
      function isRegExp(v) {
        return _toString.call(v) === '[object RegExp]';
      }
      /**
       * Check if val is a valid array index.
       */
      function isValidArrayIndex(val) {
        var n = parseFloat(String(val));
        return n >= 0 && Math.floor(n) === n && isFinite(val);
      }
      function isPromise(val) {
        return (isDef(val) &&
            typeof val.then === 'function' &&
            typeof val.catch === 'function');
      }
      /**
       * Convert a value to a string that is actually rendered.
       */
      function toString(val) {
        return val == null
            ? ''
            : Array.isArray(val) || (isPlainObject(val) && val.toString === _toString)
                ? JSON.stringify(val, null, 2)
                : String(val);
      }
      /**
       * Convert an input value to a number for persistence.
       * If the conversion fails, return original string.
       */
      function toNumber(val) {
        var n = parseFloat(val);
        return isNaN(n) ? val : n;
      }
      /**
       * Make a map and return a function for checking if a key
       * is in that map.
       */
      function makeMap(str, expectsLowerCase) {
        var map = Object.create(null);
        var list = str.split(',');
        for (var i = 0; i < list.length; i++) {
          map[list[i]] = true;
        }
        return expectsLowerCase ? function (val) { return map[val.toLowerCase()]; } : function (val) { return map[val]; };
      }
      /**
       * Check if a tag is a built-in tag.
       */
      var isBuiltInTag = makeMap('slot,component', true);
      /**
       * Check if an attribute is a reserved attribute.
       */
      var isReservedAttribute = makeMap('key,ref,slot,slot-scope,is');
      /**
       * Remove an item from an array.
       */
      function remove$2(arr, item) {
        var len = arr.length;
        if (len) {
          // fast path for the only / last item
          if (item === arr[len - 1]) {
            arr.length = len - 1;
            return;
          }
          var index = arr.indexOf(item);
          if (index > -1) {
            return arr.splice(index, 1);
          }
        }
      }
      /**
       * Check whether an object has the property.
       */
      var hasOwnProperty = Object.prototype.hasOwnProperty;
      function hasOwn(obj, key) {
        return hasOwnProperty.call(obj, key);
      }
      /**
       * Create a cached version of a pure function.
       */
      function cached(fn) {
        var cache = Object.create(null);
        return function cachedFn(str) {
          var hit = cache[str];
          return hit || (cache[str] = fn(str));
        };
      }
      /**
       * Camelize a hyphen-delimited string.
       */
      var camelizeRE = /-(\w)/g;
      var camelize = cached(function (str) {
        return str.replace(camelizeRE, function (_, c) { return (c ? c.toUpperCase() : ''); });
      });
      /**
       * Capitalize a string.
       */
      var capitalize = cached(function (str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
      });
      /**
       * Hyphenate a camelCase string.
       */
      var hyphenateRE = /\B([A-Z])/g;
      var hyphenate = cached(function (str) {
        return str.replace(hyphenateRE, '-$1').toLowerCase();
      });
      /**
       * Simple bind polyfill for environments that do not support it,
       * e.g., PhantomJS 1.x. Technically, we don't need this anymore
       * since native bind is now performant enough in most browsers.
       * But removing it would mean breaking code that was able to run in
       * PhantomJS 1.x, so this must be kept for backward compatibility.
       */
      /* istanbul ignore next */
      function polyfillBind(fn, ctx) {
        function boundFn(a) {
          var l = arguments.length;
          return l
              ? l > 1
                  ? fn.apply(ctx, arguments)
                  : fn.call(ctx, a)
              : fn.call(ctx);
        }
        boundFn._length = fn.length;
        return boundFn;
      }
      function nativeBind(fn, ctx) {
        return fn.bind(ctx);
      }
// @ts-expect-error bind cannot be `undefined`
      var bind$1 = Function.prototype.bind ? nativeBind : polyfillBind;
      /**
       * Convert an Array-like object to a real Array.
       */
      function toArray(list, start) {
        start = start || 0;
        var i = list.length - start;
        var ret = new Array(i);
        while (i--) {
          ret[i] = list[i + start];
        }
        return ret;
      }
      /**
       * Mix properties into target object.
       */
      function extend(to, _from) {
        for (var key in _from) {
          to[key] = _from[key];
        }
        return to;
      }
      /**
       * Merge an Array of Objects into a single Object.
       */
      function toObject(arr) {
        var res = {};
        for (var i = 0; i < arr.length; i++) {
          if (arr[i]) {
            extend(res, arr[i]);
          }
        }
        return res;
      }
      /* eslint-disable no-unused-vars */
      /**
       * Perform no operation.
       * Stubbing args to make Flow happy without leaving useless transpiled code
       * with ...rest (https://flow.org/blog/2017/05/07/Strict-Function-Call-Arity/).
       */
      function noop(a, b, c) { }
      /**
       * Always return false.
       */
      var no = function (a, b, c) { return false; };
      /* eslint-enable no-unused-vars */
      /**
       * Return the same value.
       */
      var identity = function (_) { return _; };
      /**
       * Generate a string containing static keys from compiler modules.
       */
      function genStaticKeys$1(modules) {
        return modules
            .reduce(function (keys, m) {
              return keys.concat(m.staticKeys || []);
            }, [])
            .join(',');
      }
      /**
       * Check if two values are loosely equal - that is,
       * if they are plain objects, do they have the same shape?
       */
      function looseEqual(a, b) {
        if (a === b)
          return true;
        var isObjectA = isObject(a);
        var isObjectB = isObject(b);
        if (isObjectA && isObjectB) {
          try {
            var isArrayA = Array.isArray(a);
            var isArrayB = Array.isArray(b);
            if (isArrayA && isArrayB) {
              return (a.length === b.length &&
                  a.every(function (e, i) {
                    return looseEqual(e, b[i]);
                  }));
            }
            else if (a instanceof Date && b instanceof Date) {
              return a.getTime() === b.getTime();
            }
            else if (!isArrayA && !isArrayB) {
              var keysA = Object.keys(a);
              var keysB = Object.keys(b);
              return (keysA.length === keysB.length &&
                  keysA.every(function (key) {
                    return looseEqual(a[key], b[key]);
                  }));
            }
            else {
              /* istanbul ignore next */
              return false;
            }
          }
          catch (e) {
            /* istanbul ignore next */
            return false;
          }
        }
        else if (!isObjectA && !isObjectB) {
          return String(a) === String(b);
        }
        else {
          return false;
        }
      }
      /**
       * Return the first index at which a loosely equal value can be
       * found in the array (if value is a plain object, the array must
       * contain an object of the same shape), or -1 if it is not present.
       */
      function looseIndexOf(arr, val) {
        for (var i = 0; i < arr.length; i++) {
          if (looseEqual(arr[i], val))
            return i;
        }
        return -1;
      }
      /**
       * Ensure a function is called only once.
       */
      function once(fn) {
        var called = false;
        return function () {
          if (!called) {
            called = true;
            fn.apply(this, arguments);
          }
        };
      }
// https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/is#polyfill
      function hasChanged(x, y) {
        if (x === y) {
          return x === 0 && 1 / x !== 1 / y;
        }
        else {
          return x === x || y === y;
        }
      }

      var SSR_ATTR = 'data-server-rendered';
      var ASSET_TYPES = ['component', 'directive', 'filter'];
      var LIFECYCLE_HOOKS = [
        'beforeCreate',
        'created',
        'beforeMount',
        'mounted',
        'beforeUpdate',
        'updated',
        'beforeDestroy',
        'destroyed',
        'activated',
        'deactivated',
        'errorCaptured',
        'serverPrefetch',
        'renderTracked',
        'renderTriggered'
      ];

      var config = {
        /**
         * Option merge strategies (used in core/util/options)
         */
        // $flow-disable-line
        optionMergeStrategies: Object.create(null),
        /**
         * Whether to suppress warnings.
         */
        silent: false,
        /**
         * Show production mode tip message on boot?
         */
        productionTip: "development" !== 'production',
        /**
         * Whether to enable devtools
         */
        devtools: "development" !== 'production',
        /**
         * Whether to record perf
         */
        performance: false,
        /**
         * Error handler for watcher errors
         */
        errorHandler: null,
        /**
         * Warn handler for watcher warns
         */
        warnHandler: null,
        /**
         * Ignore certain custom elements
         */
        ignoredElements: [],
        /**
         * Custom user key aliases for v-on
         */
        // $flow-disable-line
        keyCodes: Object.create(null),
        /**
         * Check if a tag is reserved so that it cannot be registered as a
         * component. This is platform-dependent and may be overwritten.
         */
        isReservedTag: no,
        /**
         * Check if an attribute is reserved so that it cannot be used as a component
         * prop. This is platform-dependent and may be overwritten.
         */
        isReservedAttr: no,
        /**
         * Check if a tag is an unknown element.
         * Platform-dependent.
         */
        isUnknownElement: no,
        /**
         * Get the namespace of an element
         */
        getTagNamespace: noop,
        /**
         * Parse the real tag name for the specific platform.
         */
        parsePlatformTagName: identity,
        /**
         * Check if an attribute must be bound using property, e.g. value
         * Platform-dependent.
         */
        mustUseProp: no,
        /**
         * Perform updates asynchronously. Intended to be used by Vue Test Utils
         * This will significantly reduce performance if set to false.
         */
        async: true,
        /**
         * Exposed for legacy reasons
         */
        _lifecycleHooks: LIFECYCLE_HOOKS
      };

      /**
       * unicode letters used for parsing html tags, component names and property paths.
       * using https://www.w3.org/TR/html53/semantics-scripting.html#potentialcustomelementname
       * skipping \u10000-\uEFFFF due to it freezing up PhantomJS
       */
      var unicodeRegExp = /a-zA-Z\u00B7\u00C0-\u00D6\u00D8-\u00F6\u00F8-\u037D\u037F-\u1FFF\u200C-\u200D\u203F-\u2040\u2070-\u218F\u2C00-\u2FEF\u3001-\uD7FF\uF900-\uFDCF\uFDF0-\uFFFD/;
      /**
       * Check if a string starts with $ or _
       */
      function isReserved(str) {
        var c = (str + '').charCodeAt(0);
        return c === 0x24 || c === 0x5f;
      }
      /**
       * Define a property.
       */
      function def(obj, key, val, enumerable) {
        Object.defineProperty(obj, key, {
          value: val,
          enumerable: !!enumerable,
          writable: true,
          configurable: true
        });
      }
      /**
       * Parse simple path.
       */
      var bailRE = new RegExp("[^".concat(unicodeRegExp.source, ".$_\\d]"));
      function parsePath(path) {
        if (bailRE.test(path)) {
          return;
        }
        var segments = path.split('.');
        return function (obj) {
          for (var i = 0; i < segments.length; i++) {
            if (!obj)
              return;
            obj = obj[segments[i]];
          }
          return obj;
        };
      }

// can we use __proto__?
      var hasProto = '__proto__' in {};
// Browser environment sniffing
      var inBrowser = typeof window !== 'undefined';
      var UA = inBrowser && window.navigator.userAgent.toLowerCase();
      var isIE = UA && /msie|trident/.test(UA);
      var isIE9 = UA && UA.indexOf('msie 9.0') > 0;
      var isEdge = UA && UA.indexOf('edge/') > 0;
      UA && UA.indexOf('android') > 0;
      var isIOS = UA && /iphone|ipad|ipod|ios/.test(UA);
      UA && /chrome\/\d+/.test(UA) && !isEdge;
      UA && /phantomjs/.test(UA);
      var isFF = UA && UA.match(/firefox\/(\d+)/);
// Firefox has a "watch" function on Object.prototype...
// @ts-expect-error firebox support
      var nativeWatch = {}.watch;
      var supportsPassive = false;
      if (inBrowser) {
        try {
          var opts = {};
          Object.defineProperty(opts, 'passive', {
            get: function () {
              /* istanbul ignore next */
              supportsPassive = true;
            }
          }); // https://github.com/facebook/flow/issues/285
          window.addEventListener('test-passive', null, opts);
        }
        catch (e) { }
      }
// this needs to be lazy-evaled because vue may be required before
// vue-server-renderer can set VUE_ENV
      var _isServer;
      var isServerRendering = function () {
        if (_isServer === undefined) {
          /* istanbul ignore if */
          if (!inBrowser && typeof __webpack_require__.g !== 'undefined') {
            // detect presence of vue-server-renderer and avoid
            // Webpack shimming the process
            _isServer =
                __webpack_require__.g['process'] && __webpack_require__.g['process'].env.VUE_ENV === 'server';
          }
          else {
            _isServer = false;
          }
        }
        return _isServer;
      };
// detect devtools
      var devtools = inBrowser && window.__VUE_DEVTOOLS_GLOBAL_HOOK__;
      /* istanbul ignore next */
      function isNative(Ctor) {
        return typeof Ctor === 'function' && /native code/.test(Ctor.toString());
      }
      var hasSymbol = typeof Symbol !== 'undefined' &&
          isNative(Symbol) &&
          typeof Reflect !== 'undefined' &&
          isNative(Reflect.ownKeys);
      var _Set; // $flow-disable-line
      /* istanbul ignore if */ if (typeof Set !== 'undefined' && isNative(Set)) {
        // use native Set when available.
        _Set = Set;
      }
      else {
        // a non-standard Set polyfill that only works with primitive keys.
        _Set = /** @class */ (function () {
          function Set() {
            this.set = Object.create(null);
          }
          Set.prototype.has = function (key) {
            return this.set[key] === true;
          };
          Set.prototype.add = function (key) {
            this.set[key] = true;
          };
          Set.prototype.clear = function () {
            this.set = Object.create(null);
          };
          return Set;
        }());
      }

      var currentInstance = null;
      /**
       * This is exposed for compatibility with v3 (e.g. some functions in VueUse
       * relies on it). Do not use this internally, just use `currentInstance`.
       *
       * @internal this function needs manual type declaration because it relies
       * on previously manually authored types from Vue 2
       */
      function getCurrentInstance() {
        return currentInstance && { proxy: currentInstance };
      }
      /**
       * @internal
       */
      function setCurrentInstance(vm) {
        if (vm === void 0) { vm = null; }
        if (!vm)
          currentInstance && currentInstance._scope.off();
        currentInstance = vm;
        vm && vm._scope.on();
      }

      /**
       * @internal
       */
      var VNode = /** @class */ (function () {
        function VNode(tag, data, children, text, elm, context, componentOptions, asyncFactory) {
          this.tag = tag;
          this.data = data;
          this.children = children;
          this.text = text;
          this.elm = elm;
          this.ns = undefined;
          this.context = context;
          this.fnContext = undefined;
          this.fnOptions = undefined;
          this.fnScopeId = undefined;
          this.key = data && data.key;
          this.componentOptions = componentOptions;
          this.componentInstance = undefined;
          this.parent = undefined;
          this.raw = false;
          this.isStatic = false;
          this.isRootInsert = true;
          this.isComment = false;
          this.isCloned = false;
          this.isOnce = false;
          this.asyncFactory = asyncFactory;
          this.asyncMeta = undefined;
          this.isAsyncPlaceholder = false;
        }
        Object.defineProperty(VNode.prototype, "child", {
          // DEPRECATED: alias for componentInstance for backwards compat.
          /* istanbul ignore next */
          get: function () {
            return this.componentInstance;
          },
          enumerable: false,
          configurable: true
        });
        return VNode;
      }());
      var createEmptyVNode = function (text) {
        if (text === void 0) { text = ''; }
        var node = new VNode();
        node.text = text;
        node.isComment = true;
        return node;
      };
      function createTextVNode(val) {
        return new VNode(undefined, undefined, undefined, String(val));
      }
// optimized shallow clone
// used for static nodes and slot nodes because they may be reused across
// multiple renders, cloning them avoids errors when DOM manipulations rely
// on their elm reference.
      function cloneVNode(vnode) {
        var cloned = new VNode(vnode.tag, vnode.data,
            // #7975
            // clone children array to avoid mutating original in case of cloning
            // a child.
            vnode.children && vnode.children.slice(), vnode.text, vnode.elm, vnode.context, vnode.componentOptions, vnode.asyncFactory);
        cloned.ns = vnode.ns;
        cloned.isStatic = vnode.isStatic;
        cloned.key = vnode.key;
        cloned.isComment = vnode.isComment;
        cloned.fnContext = vnode.fnContext;
        cloned.fnOptions = vnode.fnOptions;
        cloned.fnScopeId = vnode.fnScopeId;
        cloned.asyncMeta = vnode.asyncMeta;
        cloned.isCloned = true;
        return cloned;
      }

      /* not type checking this file because flow doesn't play well with Proxy */
      var initProxy;
      if (true) {
        var allowedGlobals_1 = makeMap('Infinity,undefined,NaN,isFinite,isNaN,' +
            'parseFloat,parseInt,decodeURI,decodeURIComponent,encodeURI,encodeURIComponent,' +
            'Math,Number,Date,Array,Object,Boolean,String,RegExp,Map,Set,JSON,Intl,BigInt,' +
            'require' // for Webpack/Browserify
        );
        var warnNonPresent_1 = function (target, key) {
          warn$2("Property or method \"".concat(key, "\" is not defined on the instance but ") +
              'referenced during render. Make sure that this property is reactive, ' +
              'either in the data option, or for class-based components, by ' +
              'initializing the property. ' +
              'See: https://v2.vuejs.org/v2/guide/reactivity.html#Declaring-Reactive-Properties.', target);
        };
        var warnReservedPrefix_1 = function (target, key) {
          warn$2("Property \"".concat(key, "\" must be accessed with \"$data.").concat(key, "\" because ") +
              'properties starting with "$" or "_" are not proxied in the Vue instance to ' +
              'prevent conflicts with Vue internals. ' +
              'See: https://v2.vuejs.org/v2/api/#data', target);
        };
        var hasProxy_1 = typeof Proxy !== 'undefined' && isNative(Proxy);
        if (hasProxy_1) {
          var isBuiltInModifier_1 = makeMap('stop,prevent,self,ctrl,shift,alt,meta,exact');
          config.keyCodes = new Proxy(config.keyCodes, {
            set: function (target, key, value) {
              if (isBuiltInModifier_1(key)) {
                warn$2("Avoid overwriting built-in modifier in config.keyCodes: .".concat(key));
                return false;
              }
              else {
                target[key] = value;
                return true;
              }
            }
          });
        }
        var hasHandler_1 = {
          has: function (target, key) {
            var has = key in target;
            var isAllowed = allowedGlobals_1(key) ||
                (typeof key === 'string' &&
                    key.charAt(0) === '_' &&
                    !(key in target.$data));
            if (!has && !isAllowed) {
              if (key in target.$data)
                warnReservedPrefix_1(target, key);
              else
                warnNonPresent_1(target, key);
            }
            return has || !isAllowed;
          }
        };
        var getHandler_1 = {
          get: function (target, key) {
            if (typeof key === 'string' && !(key in target)) {
              if (key in target.$data)
                warnReservedPrefix_1(target, key);
              else
                warnNonPresent_1(target, key);
            }
            return target[key];
          }
        };
        initProxy = function initProxy(vm) {
          if (hasProxy_1) {
            // determine which proxy handler to use
            var options = vm.$options;
            var handlers = options.render && options.render._withStripped ? getHandler_1 : hasHandler_1;
            vm._renderProxy = new Proxy(vm, handlers);
          }
          else {
            vm._renderProxy = vm;
          }
        };
      }

      /******************************************************************************
       Copyright (c) Microsoft Corporation.

       Permission to use, copy, modify, and/or distribute this software for any
       purpose with or without fee is hereby granted.

       THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES WITH
       REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF MERCHANTABILITY
       AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY SPECIAL, DIRECT,
       INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES WHATSOEVER RESULTING FROM
       LOSS OF USE, DATA OR PROFITS, WHETHER IN AN ACTION OF CONTRACT, NEGLIGENCE OR
       OTHER TORTIOUS ACTION, ARISING OUT OF OR IN CONNECTION WITH THE USE OR
       PERFORMANCE OF THIS SOFTWARE.
       ***************************************************************************** */

      var __assign = function() {
        __assign = Object.assign || function __assign(t) {
          for (var s, i = 1, n = arguments.length; i < n; i++) {
            s = arguments[i];
            for (var p in s) if (Object.prototype.hasOwnProperty.call(s, p)) t[p] = s[p];
          }
          return t;
        };
        return __assign.apply(this, arguments);
      };

      var uid$2 = 0;
      var pendingCleanupDeps = [];
      var cleanupDeps = function () {
        for (var i = 0; i < pendingCleanupDeps.length; i++) {
          var dep = pendingCleanupDeps[i];
          dep.subs = dep.subs.filter(function (s) { return s; });
          dep._pending = false;
        }
        pendingCleanupDeps.length = 0;
      };
      /**
       * A dep is an observable that can have multiple
       * directives subscribing to it.
       * @internal
       */
      var Dep = /** @class */ (function () {
        function Dep() {
          // pending subs cleanup
          this._pending = false;
          this.id = uid$2++;
          this.subs = [];
        }
        Dep.prototype.addSub = function (sub) {
          this.subs.push(sub);
        };
        Dep.prototype.removeSub = function (sub) {
          // #12696 deps with massive amount of subscribers are extremely slow to
          // clean up in Chromium
          // to workaround this, we unset the sub for now, and clear them on
          // next scheduler flush.
          this.subs[this.subs.indexOf(sub)] = null;
          if (!this._pending) {
            this._pending = true;
            pendingCleanupDeps.push(this);
          }
        };
        Dep.prototype.depend = function (info) {
          if (Dep.target) {
            Dep.target.addDep(this);
            if ( true && info && Dep.target.onTrack) {
              Dep.target.onTrack(__assign({ effect: Dep.target }, info));
            }
          }
        };
        Dep.prototype.notify = function (info) {
          // stabilize the subscriber list first
          var subs = this.subs.filter(function (s) { return s; });
          if ( true && !config.async) {
            // subs aren't sorted in scheduler if not running async
            // we need to sort them now to make sure they fire in correct
            // order
            subs.sort(function (a, b) { return a.id - b.id; });
          }
          for (var i = 0, l = subs.length; i < l; i++) {
            var sub = subs[i];
            if ( true && info) {
              sub.onTrigger &&
              sub.onTrigger(__assign({ effect: subs[i] }, info));
            }
            sub.update();
          }
        };
        return Dep;
      }());
// The current target watcher being evaluated.
// This is globally unique because only one watcher
// can be evaluated at a time.
      Dep.target = null;
      var targetStack = [];
      function pushTarget(target) {
        targetStack.push(target);
        Dep.target = target;
      }
      function popTarget() {
        targetStack.pop();
        Dep.target = targetStack[targetStack.length - 1];
      }

      /*
 * not type checking this file because flow doesn't play well with
 * dynamically accessing methods on Array prototype
 */
      var arrayProto = Array.prototype;
      var arrayMethods = Object.create(arrayProto);
      var methodsToPatch = [
        'push',
        'pop',
        'shift',
        'unshift',
        'splice',
        'sort',
        'reverse'
      ];
      /**
       * Intercept mutating methods and emit events
       */
      methodsToPatch.forEach(function (method) {
        // cache original method
        var original = arrayProto[method];
        def(arrayMethods, method, function mutator() {
          var args = [];
          for (var _i = 0; _i < arguments.length; _i++) {
            args[_i] = arguments[_i];
          }
          var result = original.apply(this, args);
          var ob = this.__ob__;
          var inserted;
          switch (method) {
            case 'push':
            case 'unshift':
              inserted = args;
              break;
            case 'splice':
              inserted = args.slice(2);
              break;
          }
          if (inserted)
            ob.observeArray(inserted);
          // notify change
          if (true) {
            ob.dep.notify({
              type: "array mutation" /* TriggerOpTypes.ARRAY_MUTATION */,
              target: this,
              key: method
            });
          }
          else {}
          return result;
        });
      });

      var arrayKeys = Object.getOwnPropertyNames(arrayMethods);
      var NO_INIITIAL_VALUE = {};
      /**
       * In some cases we may want to disable observation inside a component's
       * update computation.
       */
      var shouldObserve = true;
      function toggleObserving(value) {
        shouldObserve = value;
      }
// ssr mock dep
      var mockDep = {
        notify: noop,
        depend: noop,
        addSub: noop,
        removeSub: noop
      };
      /**
       * Observer class that is attached to each observed
       * object. Once attached, the observer converts the target
       * object's property keys into getter/setters that
       * collect dependencies and dispatch updates.
       */
      var Observer = /** @class */ (function () {
        function Observer(value, shallow, mock) {
          if (shallow === void 0) { shallow = false; }
          if (mock === void 0) { mock = false; }
          this.value = value;
          this.shallow = shallow;
          this.mock = mock;
          // this.value = value
          this.dep = mock ? mockDep : new Dep();
          this.vmCount = 0;
          def(value, '__ob__', this);
          if (isArray(value)) {
            if (!mock) {
              if (hasProto) {
                value.__proto__ = arrayMethods;
                /* eslint-enable no-proto */
              }
              else {
                for (var i = 0, l = arrayKeys.length; i < l; i++) {
                  var key = arrayKeys[i];
                  def(value, key, arrayMethods[key]);
                }
              }
            }
            if (!shallow) {
              this.observeArray(value);
            }
          }
          else {
            /**
             * Walk through all properties and convert them into
             * getter/setters. This method should only be called when
             * value type is Object.
             */
            var keys = Object.keys(value);
            for (var i = 0; i < keys.length; i++) {
              var key = keys[i];
              defineReactive(value, key, NO_INIITIAL_VALUE, undefined, shallow, mock);
            }
          }
        }
        /**
         * Observe a list of Array items.
         */
        Observer.prototype.observeArray = function (value) {
          for (var i = 0, l = value.length; i < l; i++) {
            observe(value[i], false, this.mock);
          }
        };
        return Observer;
      }());
// helpers
      /**
       * Attempt to create an observer instance for a value,
       * returns the new observer if successfully observed,
       * or the existing observer if the value already has one.
       */
      function observe(value, shallow, ssrMockReactivity) {
        if (value && hasOwn(value, '__ob__') && value.__ob__ instanceof Observer) {
          return value.__ob__;
        }
        if (shouldObserve &&
            (ssrMockReactivity || !isServerRendering()) &&
            (isArray(value) || isPlainObject(value)) &&
            Object.isExtensible(value) &&
            !value.__v_skip /* ReactiveFlags.SKIP */ &&
            !isRef(value) &&
            !(value instanceof VNode)) {
          return new Observer(value, shallow, ssrMockReactivity);
        }
      }
      /**
       * Define a reactive property on an Object.
       */
      function defineReactive(obj, key, val, customSetter, shallow, mock) {
        var dep = new Dep();
        var property = Object.getOwnPropertyDescriptor(obj, key);
        if (property && property.configurable === false) {
          return;
        }
        // cater for pre-defined getter/setters
        var getter = property && property.get;
        var setter = property && property.set;
        if ((!getter || setter) &&
            (val === NO_INIITIAL_VALUE || arguments.length === 2)) {
          val = obj[key];
        }
        var childOb = !shallow && observe(val, false, mock);
        Object.defineProperty(obj, key, {
          enumerable: true,
          configurable: true,
          get: function reactiveGetter() {
            var value = getter ? getter.call(obj) : val;
            if (Dep.target) {
              if (true) {
                dep.depend({
                  target: obj,
                  type: "get" /* TrackOpTypes.GET */,
                  key: key
                });
              }
              else {}
              if (childOb) {
                childOb.dep.depend();
                if (isArray(value)) {
                  dependArray(value);
                }
              }
            }
            return isRef(value) && !shallow ? value.value : value;
          },
          set: function reactiveSetter(newVal) {
            var value = getter ? getter.call(obj) : val;
            if (!hasChanged(value, newVal)) {
              return;
            }
            if ( true && customSetter) {
              customSetter();
            }
            if (setter) {
              setter.call(obj, newVal);
            }
            else if (getter) {
              // #7981: for accessor properties without setter
              return;
            }
            else if (!shallow && isRef(value) && !isRef(newVal)) {
              value.value = newVal;
              return;
            }
            else {
              val = newVal;
            }
            childOb = !shallow && observe(newVal, false, mock);
            if (true) {
              dep.notify({
                type: "set" /* TriggerOpTypes.SET */,
                target: obj,
                key: key,
                newValue: newVal,
                oldValue: value
              });
            }
            else {}
          }
        });
        return dep;
      }
      function set(target, key, val) {
        if ( true && (isUndef(target) || isPrimitive(target))) {
          warn$2("Cannot set reactive property on undefined, null, or primitive value: ".concat(target));
        }
        if (isReadonly(target)) {
          true && warn$2("Set operation on key \"".concat(key, "\" failed: target is readonly."));
          return;
        }
        var ob = target.__ob__;
        if (isArray(target) && isValidArrayIndex(key)) {
          target.length = Math.max(target.length, key);
          target.splice(key, 1, val);
          // when mocking for SSR, array methods are not hijacked
          if (ob && !ob.shallow && ob.mock) {
            observe(val, false, true);
          }
          return val;
        }
        if (key in target && !(key in Object.prototype)) {
          target[key] = val;
          return val;
        }
        if (target._isVue || (ob && ob.vmCount)) {
          true &&
          warn$2('Avoid adding reactive properties to a Vue instance or its root $data ' +
              'at runtime - declare it upfront in the data option.');
          return val;
        }
        if (!ob) {
          target[key] = val;
          return val;
        }
        defineReactive(ob.value, key, val, undefined, ob.shallow, ob.mock);
        if (true) {
          ob.dep.notify({
            type: "add" /* TriggerOpTypes.ADD */,
            target: target,
            key: key,
            newValue: val,
            oldValue: undefined
          });
        }
        else {}
        return val;
      }
      function del(target, key) {
        if ( true && (isUndef(target) || isPrimitive(target))) {
          warn$2("Cannot delete reactive property on undefined, null, or primitive value: ".concat(target));
        }
        if (isArray(target) && isValidArrayIndex(key)) {
          target.splice(key, 1);
          return;
        }
        var ob = target.__ob__;
        if (target._isVue || (ob && ob.vmCount)) {
          true &&
          warn$2('Avoid deleting properties on a Vue instance or its root $data ' +
              '- just set it to null.');
          return;
        }
        if (isReadonly(target)) {
          true &&
          warn$2("Delete operation on key \"".concat(key, "\" failed: target is readonly."));
          return;
        }
        if (!hasOwn(target, key)) {
          return;
        }
        delete target[key];
        if (!ob) {
          return;
        }
        if (true) {
          ob.dep.notify({
            type: "delete" /* TriggerOpTypes.DELETE */,
            target: target,
            key: key
          });
        }
        else {}
      }
      /**
       * Collect dependencies on array elements when the array is touched, since
       * we cannot intercept array element access like property getters.
       */
      function dependArray(value) {
        for (var e = void 0, i = 0, l = value.length; i < l; i++) {
          e = value[i];
          if (e && e.__ob__) {
            e.__ob__.dep.depend();
          }
          if (isArray(e)) {
            dependArray(e);
          }
        }
      }

      function reactive(target) {
        makeReactive(target, false);
        return target;
      }
      /**
       * Return a shallowly-reactive copy of the original object, where only the root
       * level properties are reactive. It also does not auto-unwrap refs (even at the
       * root level).
       */
      function shallowReactive(target) {
        makeReactive(target, true);
        def(target, "__v_isShallow" /* ReactiveFlags.IS_SHALLOW */, true);
        return target;
      }
      function makeReactive(target, shallow) {
        // if trying to observe a readonly proxy, return the readonly version.
        if (!isReadonly(target)) {
          if (true) {
            if (isArray(target)) {
              warn$2("Avoid using Array as root value for ".concat(shallow ? "shallowReactive()" : "reactive()", " as it cannot be tracked in watch() or watchEffect(). Use ").concat(shallow ? "shallowRef()" : "ref()", " instead. This is a Vue-2-only limitation."));
            }
            var existingOb = target && target.__ob__;
            if (existingOb && existingOb.shallow !== shallow) {
              warn$2("Target is already a ".concat(existingOb.shallow ? "" : "non-", "shallow reactive object, and cannot be converted to ").concat(shallow ? "" : "non-", "shallow."));
            }
          }
          var ob = observe(target, shallow, isServerRendering() /* ssr mock reactivity */);
          if ( true && !ob) {
            if (target == null || isPrimitive(target)) {
              warn$2("value cannot be made reactive: ".concat(String(target)));
            }
            if (isCollectionType(target)) {
              warn$2("Vue 2 does not support reactive collection types such as Map or Set.");
            }
          }
        }
      }
      function isReactive(value) {
        if (isReadonly(value)) {
          return isReactive(value["__v_raw" /* ReactiveFlags.RAW */]);
        }
        return !!(value && value.__ob__);
      }
      function isShallow(value) {
        return !!(value && value.__v_isShallow);
      }
      function isReadonly(value) {
        return !!(value && value.__v_isReadonly);
      }
      function isProxy(value) {
        return isReactive(value) || isReadonly(value);
      }
      function toRaw(observed) {
        var raw = observed && observed["__v_raw" /* ReactiveFlags.RAW */];
        return raw ? toRaw(raw) : observed;
      }
      function markRaw(value) {
        // non-extensible objects won't be observed anyway
        if (Object.isExtensible(value)) {
          def(value, "__v_skip" /* ReactiveFlags.SKIP */, true);
        }
        return value;
      }
      /**
       * @internal
       */
      function isCollectionType(value) {
        var type = toRawType(value);
        return (type === 'Map' || type === 'WeakMap' || type === 'Set' || type === 'WeakSet');
      }

      /**
       * @internal
       */
      var RefFlag = "__v_isRef";
      function isRef(r) {
        return !!(r && r.__v_isRef === true);
      }
      function ref$1(value) {
        return createRef(value, false);
      }
      function shallowRef(value) {
        return createRef(value, true);
      }
      function createRef(rawValue, shallow) {
        if (isRef(rawValue)) {
          return rawValue;
        }
        var ref = {};
        def(ref, RefFlag, true);
        def(ref, "__v_isShallow" /* ReactiveFlags.IS_SHALLOW */, shallow);
        def(ref, 'dep', defineReactive(ref, 'value', rawValue, null, shallow, isServerRendering()));
        return ref;
      }
      function triggerRef(ref) {
        if ( true && !ref.dep) {
          warn$2("received object is not a triggerable ref.");
        }
        if (true) {
          ref.dep &&
          ref.dep.notify({
            type: "set" /* TriggerOpTypes.SET */,
            target: ref,
            key: 'value'
          });
        }
        else {}
      }
      function unref(ref) {
        return isRef(ref) ? ref.value : ref;
      }
      function proxyRefs(objectWithRefs) {
        if (isReactive(objectWithRefs)) {
          return objectWithRefs;
        }
        var proxy = {};
        var keys = Object.keys(objectWithRefs);
        for (var i = 0; i < keys.length; i++) {
          proxyWithRefUnwrap(proxy, objectWithRefs, keys[i]);
        }
        return proxy;
      }
      function proxyWithRefUnwrap(target, source, key) {
        Object.defineProperty(target, key, {
          enumerable: true,
          configurable: true,
          get: function () {
            var val = source[key];
            if (isRef(val)) {
              return val.value;
            }
            else {
              var ob = val && val.__ob__;
              if (ob)
                ob.dep.depend();
              return val;
            }
          },
          set: function (value) {
            var oldValue = source[key];
            if (isRef(oldValue) && !isRef(value)) {
              oldValue.value = value;
            }
            else {
              source[key] = value;
            }
          }
        });
      }
      function customRef(factory) {
        var dep = new Dep();
        var _a = factory(function () {
          if (true) {
            dep.depend({
              target: ref,
              type: "get" /* TrackOpTypes.GET */,
              key: 'value'
            });
          }
          else {}
        }, function () {
          if (true) {
            dep.notify({
              target: ref,
              type: "set" /* TriggerOpTypes.SET */,
              key: 'value'
            });
          }
          else {}
        }), get = _a.get, set = _a.set;
        var ref = {
          get value() {
            return get();
          },
          set value(newVal) {
            set(newVal);
          }
        };
        def(ref, RefFlag, true);
        return ref;
      }
      function toRefs(object) {
        if ( true && !isReactive(object)) {
          warn$2("toRefs() expects a reactive object but received a plain one.");
        }
        var ret = isArray(object) ? new Array(object.length) : {};
        for (var key in object) {
          ret[key] = toRef(object, key);
        }
        return ret;
      }
      function toRef(object, key, defaultValue) {
        var val = object[key];
        if (isRef(val)) {
          return val;
        }
        var ref = {
          get value() {
            var val = object[key];
            return val === undefined ? defaultValue : val;
          },
          set value(newVal) {
            object[key] = newVal;
          }
        };
        def(ref, RefFlag, true);
        return ref;
      }

      var rawToReadonlyFlag = "__v_rawToReadonly";
      var rawToShallowReadonlyFlag = "__v_rawToShallowReadonly";
      function readonly(target) {
        return createReadonly(target, false);
      }
      function createReadonly(target, shallow) {
        if (!isPlainObject(target)) {
          if (true) {
            if (isArray(target)) {
              warn$2("Vue 2 does not support readonly arrays.");
            }
            else if (isCollectionType(target)) {
              warn$2("Vue 2 does not support readonly collection types such as Map or Set.");
            }
            else {
              warn$2("value cannot be made readonly: ".concat(typeof target));
            }
          }
          return target;
        }
        if ( true && !Object.isExtensible(target)) {
          warn$2("Vue 2 does not support creating readonly proxy for non-extensible object.");
        }
        // already a readonly object
        if (isReadonly(target)) {
          return target;
        }
        // already has a readonly proxy
        var existingFlag = shallow ? rawToShallowReadonlyFlag : rawToReadonlyFlag;
        var existingProxy = target[existingFlag];
        if (existingProxy) {
          return existingProxy;
        }
        var proxy = Object.create(Object.getPrototypeOf(target));
        def(target, existingFlag, proxy);
        def(proxy, "__v_isReadonly" /* ReactiveFlags.IS_READONLY */, true);
        def(proxy, "__v_raw" /* ReactiveFlags.RAW */, target);
        if (isRef(target)) {
          def(proxy, RefFlag, true);
        }
        if (shallow || isShallow(target)) {
          def(proxy, "__v_isShallow" /* ReactiveFlags.IS_SHALLOW */, true);
        }
        var keys = Object.keys(target);
        for (var i = 0; i < keys.length; i++) {
          defineReadonlyProperty(proxy, target, keys[i], shallow);
        }
        return proxy;
      }
      function defineReadonlyProperty(proxy, target, key, shallow) {
        Object.defineProperty(proxy, key, {
          enumerable: true,
          configurable: true,
          get: function () {
            var val = target[key];
            return shallow || !isPlainObject(val) ? val : readonly(val);
          },
          set: function () {
            true &&
            warn$2("Set operation on key \"".concat(key, "\" failed: target is readonly."));
          }
        });
      }
      /**
       * Returns a reactive-copy of the original object, where only the root level
       * properties are readonly, and does NOT unwrap refs nor recursively convert
       * returned properties.
       * This is used for creating the props proxy object for stateful components.
       */
      function shallowReadonly(target) {
        return createReadonly(target, true);
      }

      function computed(getterOrOptions, debugOptions) {
        var getter;
        var setter;
        var onlyGetter = isFunction(getterOrOptions);
        if (onlyGetter) {
          getter = getterOrOptions;
          setter =  true
              ? function () {
                warn$2('Write operation failed: computed value is readonly');
              }
              : 0;
        }
        else {
          getter = getterOrOptions.get;
          setter = getterOrOptions.set;
        }
        var watcher = isServerRendering()
            ? null
            : new Watcher(currentInstance, getter, noop, { lazy: true });
        if ( true && watcher && debugOptions) {
          watcher.onTrack = debugOptions.onTrack;
          watcher.onTrigger = debugOptions.onTrigger;
        }
        var ref = {
          // some libs rely on the presence effect for checking computed refs
          // from normal refs, but the implementation doesn't matter
          effect: watcher,
          get value() {
            if (watcher) {
              if (watcher.dirty) {
                watcher.evaluate();
              }
              if (Dep.target) {
                if ( true && Dep.target.onTrack) {
                  Dep.target.onTrack({
                    effect: Dep.target,
                    target: ref,
                    type: "get" /* TrackOpTypes.GET */,
                    key: 'value'
                  });
                }
                watcher.depend();
              }
              return watcher.value;
            }
            else {
              return getter();
            }
          },
          set value(newVal) {
            setter(newVal);
          }
        };
        def(ref, RefFlag, true);
        def(ref, "__v_isReadonly" /* ReactiveFlags.IS_READONLY */, onlyGetter);
        return ref;
      }

      var mark;
      var measure;
      if (true) {
        var perf_1 = inBrowser && window.performance;
        /* istanbul ignore if */
        if (perf_1 &&
            // @ts-ignore
            perf_1.mark &&
            // @ts-ignore
            perf_1.measure &&
            // @ts-ignore
            perf_1.clearMarks &&
            // @ts-ignore
            perf_1.clearMeasures) {
          mark = function (tag) { return perf_1.mark(tag); };
          measure = function (name, startTag, endTag) {
            perf_1.measure(name, startTag, endTag);
            perf_1.clearMarks(startTag);
            perf_1.clearMarks(endTag);
            // perf.clearMeasures(name)
          };
        }
      }

      var normalizeEvent = cached(function (name) {
        var passive = name.charAt(0) === '&';
        name = passive ? name.slice(1) : name;
        var once = name.charAt(0) === '~'; // Prefixed last, checked first
        name = once ? name.slice(1) : name;
        var capture = name.charAt(0) === '!';
        name = capture ? name.slice(1) : name;
        return {
          name: name,
          once: once,
          capture: capture,
          passive: passive
        };
      });
      function createFnInvoker(fns, vm) {
        function invoker() {
          var fns = invoker.fns;
          if (isArray(fns)) {
            var cloned = fns.slice();
            for (var i = 0; i < cloned.length; i++) {
              invokeWithErrorHandling(cloned[i], null, arguments, vm, "v-on handler");
            }
          }
          else {
            // return handler return value for single handlers
            return invokeWithErrorHandling(fns, null, arguments, vm, "v-on handler");
          }
        }
        invoker.fns = fns;
        return invoker;
      }
      function updateListeners(on, oldOn, add, remove, createOnceHandler, vm) {
        var name, cur, old, event;
        for (name in on) {
          cur = on[name];
          old = oldOn[name];
          event = normalizeEvent(name);
          if (isUndef(cur)) {
            true &&
            warn$2("Invalid handler for event \"".concat(event.name, "\": got ") + String(cur), vm);
          }
          else if (isUndef(old)) {
            if (isUndef(cur.fns)) {
              cur = on[name] = createFnInvoker(cur, vm);
            }
            if (isTrue(event.once)) {
              cur = on[name] = createOnceHandler(event.name, cur, event.capture);
            }
            add(event.name, cur, event.capture, event.passive, event.params);
          }
          else if (cur !== old) {
            old.fns = cur;
            on[name] = old;
          }
        }
        for (name in oldOn) {
          if (isUndef(on[name])) {
            event = normalizeEvent(name);
            remove(event.name, oldOn[name], event.capture);
          }
        }
      }

      function mergeVNodeHook(def, hookKey, hook) {
        if (def instanceof VNode) {
          def = def.data.hook || (def.data.hook = {});
        }
        var invoker;
        var oldHook = def[hookKey];
        function wrappedHook() {
          hook.apply(this, arguments);
          // important: remove merged hook to ensure it's called only once
          // and prevent memory leak
          remove$2(invoker.fns, wrappedHook);
        }
        if (isUndef(oldHook)) {
          // no existing hook
          invoker = createFnInvoker([wrappedHook]);
        }
        else {
          /* istanbul ignore if */
          if (isDef(oldHook.fns) && isTrue(oldHook.merged)) {
            // already a merged invoker
            invoker = oldHook;
            invoker.fns.push(wrappedHook);
          }
          else {
            // existing plain hook
            invoker = createFnInvoker([oldHook, wrappedHook]);
          }
        }
        invoker.merged = true;
        def[hookKey] = invoker;
      }

      function extractPropsFromVNodeData(data, Ctor, tag) {
        // we are only extracting raw values here.
        // validation and default values are handled in the child
        // component itself.
        var propOptions = Ctor.options.props;
        if (isUndef(propOptions)) {
          return;
        }
        var res = {};
        var attrs = data.attrs, props = data.props;
        if (isDef(attrs) || isDef(props)) {
          for (var key in propOptions) {
            var altKey = hyphenate(key);
            if (true) {
              var keyInLowerCase = key.toLowerCase();
              if (key !== keyInLowerCase && attrs && hasOwn(attrs, keyInLowerCase)) {
                tip("Prop \"".concat(keyInLowerCase, "\" is passed to component ") +
                    "".concat(formatComponentName(
                        // @ts-expect-error tag is string
                        tag || Ctor), ", but the declared prop name is") +
                    " \"".concat(key, "\". ") +
                    "Note that HTML attributes are case-insensitive and camelCased " +
                    "props need to use their kebab-case equivalents when using in-DOM " +
                    "templates. You should probably use \"".concat(altKey, "\" instead of \"").concat(key, "\"."));
              }
            }
            checkProp(res, props, key, altKey, true) ||
            checkProp(res, attrs, key, altKey, false);
          }
        }
        return res;
      }
      function checkProp(res, hash, key, altKey, preserve) {
        if (isDef(hash)) {
          if (hasOwn(hash, key)) {
            res[key] = hash[key];
            if (!preserve) {
              delete hash[key];
            }
            return true;
          }
          else if (hasOwn(hash, altKey)) {
            res[key] = hash[altKey];
            if (!preserve) {
              delete hash[altKey];
            }
            return true;
          }
        }
        return false;
      }

// The template compiler attempts to minimize the need for normalization by
// statically analyzing the template at compile time.
//
// For plain HTML markup, normalization can be completely skipped because the
// generated render function is guaranteed to return Array<VNode>. There are
// two cases where extra normalization is needed:
// 1. When the children contains components - because a functional component
// may return an Array instead of a single root. In this case, just a simple
// normalization is needed - if any child is an Array, we flatten the whole
// thing with Array.prototype.concat. It is guaranteed to be only 1-level deep
// because functional components already normalize their own children.
      function simpleNormalizeChildren(children) {
        for (var i = 0; i < children.length; i++) {
          if (isArray(children[i])) {
            return Array.prototype.concat.apply([], children);
          }
        }
        return children;
      }
// 2. When the children contains constructs that always generated nested Arrays,
// e.g. <template>, <slot>, v-for, or when the children is provided by user
// with hand-written render functions / JSX. In such cases a full normalization
// is needed to cater to all possible types of children values.
      function normalizeChildren(children) {
        return isPrimitive(children)
            ? [createTextVNode(children)]
            : isArray(children)
                ? normalizeArrayChildren(children)
                : undefined;
      }
      function isTextNode(node) {
        return isDef(node) && isDef(node.text) && isFalse(node.isComment);
      }
      function normalizeArrayChildren(children, nestedIndex) {
        var res = [];
        var i, c, lastIndex, last;
        for (i = 0; i < children.length; i++) {
          c = children[i];
          if (isUndef(c) || typeof c === 'boolean')
            continue;
          lastIndex = res.length - 1;
          last = res[lastIndex];
          //  nested
          if (isArray(c)) {
            if (c.length > 0) {
              c = normalizeArrayChildren(c, "".concat(nestedIndex || '', "_").concat(i));
              // merge adjacent text nodes
              if (isTextNode(c[0]) && isTextNode(last)) {
                res[lastIndex] = createTextVNode(last.text + c[0].text);
                c.shift();
              }
              res.push.apply(res, c);
            }
          }
          else if (isPrimitive(c)) {
            if (isTextNode(last)) {
              // merge adjacent text nodes
              // this is necessary for SSR hydration because text nodes are
              // essentially merged when rendered to HTML strings
              res[lastIndex] = createTextVNode(last.text + c);
            }
            else if (c !== '') {
              // convert primitive to vnode
              res.push(createTextVNode(c));
            }
          }
          else {
            if (isTextNode(c) && isTextNode(last)) {
              // merge adjacent text nodes
              res[lastIndex] = createTextVNode(last.text + c.text);
            }
            else {
              // default key for nested array children (likely generated by v-for)
              if (isTrue(children._isVList) &&
                  isDef(c.tag) &&
                  isUndef(c.key) &&
                  isDef(nestedIndex)) {
                c.key = "__vlist".concat(nestedIndex, "_").concat(i, "__");
              }
              res.push(c);
            }
          }
        }
        return res;
      }

      var SIMPLE_NORMALIZE = 1;
      var ALWAYS_NORMALIZE = 2;
// wrapper function for providing a more flexible interface
// without getting yelled at by flow
      function createElement$1(context, tag, data, children, normalizationType, alwaysNormalize) {
        if (isArray(data) || isPrimitive(data)) {
          normalizationType = children;
          children = data;
          data = undefined;
        }
        if (isTrue(alwaysNormalize)) {
          normalizationType = ALWAYS_NORMALIZE;
        }
        return _createElement(context, tag, data, children, normalizationType);
      }
      function _createElement(context, tag, data, children, normalizationType) {
        if (isDef(data) && isDef(data.__ob__)) {
          true &&
          warn$2("Avoid using observed data object as vnode data: ".concat(JSON.stringify(data), "\n") + 'Always create fresh vnode data objects in each render!', context);
          return createEmptyVNode();
        }
        // object syntax in v-bind
        if (isDef(data) && isDef(data.is)) {
          tag = data.is;
        }
        if (!tag) {
          // in case of component :is set to falsy value
          return createEmptyVNode();
        }
        // warn against non-primitive key
        if ( true && isDef(data) && isDef(data.key) && !isPrimitive(data.key)) {
          warn$2('Avoid using non-primitive value as key, ' +
              'use string/number value instead.', context);
        }
        // support single function children as default scoped slot
        if (isArray(children) && isFunction(children[0])) {
          data = data || {};
          data.scopedSlots = { default: children[0] };
          children.length = 0;
        }
        if (normalizationType === ALWAYS_NORMALIZE) {
          children = normalizeChildren(children);
        }
        else if (normalizationType === SIMPLE_NORMALIZE) {
          children = simpleNormalizeChildren(children);
        }
        var vnode, ns;
        if (typeof tag === 'string') {
          var Ctor = void 0;
          ns = (context.$vnode && context.$vnode.ns) || config.getTagNamespace(tag);
          if (config.isReservedTag(tag)) {
            // platform built-in elements
            if ( true &&
                isDef(data) &&
                isDef(data.nativeOn) &&
                data.tag !== 'component') {
              warn$2("The .native modifier for v-on is only valid on components but it was used on <".concat(tag, ">."), context);
            }
            vnode = new VNode(config.parsePlatformTagName(tag), data, children, undefined, undefined, context);
          }
          else if ((!data || !data.pre) &&
              isDef((Ctor = resolveAsset(context.$options, 'components', tag)))) {
            // component
            vnode = createComponent(Ctor, data, context, children, tag);
          }
          else {
            // unknown or unlisted namespaced elements
            // check at runtime because it may get assigned a namespace when its
            // parent normalizes children
            vnode = new VNode(tag, data, children, undefined, undefined, context);
          }
        }
        else {
          // direct component options / constructor
          vnode = createComponent(tag, data, context, children);
        }
        if (isArray(vnode)) {
          return vnode;
        }
        else if (isDef(vnode)) {
          if (isDef(ns))
            applyNS(vnode, ns);
          if (isDef(data))
            registerDeepBindings(data);
          return vnode;
        }
        else {
          return createEmptyVNode();
        }
      }
      function applyNS(vnode, ns, force) {
        vnode.ns = ns;
        if (vnode.tag === 'foreignObject') {
          // use default namespace inside foreignObject
          ns = undefined;
          force = true;
        }
        if (isDef(vnode.children)) {
          for (var i = 0, l = vnode.children.length; i < l; i++) {
            var child = vnode.children[i];
            if (isDef(child.tag) &&
                (isUndef(child.ns) || (isTrue(force) && child.tag !== 'svg'))) {
              applyNS(child, ns, force);
            }
          }
        }
      }
// ref #5318
// necessary to ensure parent re-render when deep bindings like :style and
// :class are used on slot nodes
      function registerDeepBindings(data) {
        if (isObject(data.style)) {
          traverse(data.style);
        }
        if (isObject(data.class)) {
          traverse(data.class);
        }
      }

      /**
       * Runtime helper for rendering v-for lists.
       */
      function renderList(val, render) {
        var ret = null, i, l, keys, key;
        if (isArray(val) || typeof val === 'string') {
          ret = new Array(val.length);
          for (i = 0, l = val.length; i < l; i++) {
            ret[i] = render(val[i], i);
          }
        }
        else if (typeof val === 'number') {
          ret = new Array(val);
          for (i = 0; i < val; i++) {
            ret[i] = render(i + 1, i);
          }
        }
        else if (isObject(val)) {
          if (hasSymbol && val[Symbol.iterator]) {
            ret = [];
            var iterator = val[Symbol.iterator]();
            var result = iterator.next();
            while (!result.done) {
              ret.push(render(result.value, ret.length));
              result = iterator.next();
            }
          }
          else {
            keys = Object.keys(val);
            ret = new Array(keys.length);
            for (i = 0, l = keys.length; i < l; i++) {
              key = keys[i];
              ret[i] = render(val[key], key, i);
            }
          }
        }
        if (!isDef(ret)) {
          ret = [];
        }
        ret._isVList = true;
        return ret;
      }

      /**
       * Runtime helper for rendering <slot>
       */
      function renderSlot(name, fallbackRender, props, bindObject) {
        var scopedSlotFn = this.$scopedSlots[name];
        var nodes;
        if (scopedSlotFn) {
          // scoped slot
          props = props || {};
          if (bindObject) {
            if ( true && !isObject(bindObject)) {
              warn$2('slot v-bind without argument expects an Object', this);
            }
            props = extend(extend({}, bindObject), props);
          }
          nodes =
              scopedSlotFn(props) ||
              (isFunction(fallbackRender) ? fallbackRender() : fallbackRender);
        }
        else {
          nodes =
              this.$slots[name] ||
              (isFunction(fallbackRender) ? fallbackRender() : fallbackRender);
        }
        var target = props && props.slot;
        if (target) {
          return this.$createElement('template', { slot: target }, nodes);
        }
        else {
          return nodes;
        }
      }

      /**
       * Runtime helper for resolving filters
       */
      function resolveFilter(id) {
        return resolveAsset(this.$options, 'filters', id, true) || identity;
      }

      function isKeyNotMatch(expect, actual) {
        if (isArray(expect)) {
          return expect.indexOf(actual) === -1;
        }
        else {
          return expect !== actual;
        }
      }
      /**
       * Runtime helper for checking keyCodes from config.
       * exposed as Vue.prototype._k
       * passing in eventKeyName as last argument separately for backwards compat
       */
      function checkKeyCodes(eventKeyCode, key, builtInKeyCode, eventKeyName, builtInKeyName) {
        var mappedKeyCode = config.keyCodes[key] || builtInKeyCode;
        if (builtInKeyName && eventKeyName && !config.keyCodes[key]) {
          return isKeyNotMatch(builtInKeyName, eventKeyName);
        }
        else if (mappedKeyCode) {
          return isKeyNotMatch(mappedKeyCode, eventKeyCode);
        }
        else if (eventKeyName) {
          return hyphenate(eventKeyName) !== key;
        }
        return eventKeyCode === undefined;
      }

      /**
       * Runtime helper for merging v-bind="object" into a VNode's data.
       */
      function bindObjectProps(data, tag, value, asProp, isSync) {
        if (value) {
          if (!isObject(value)) {
            true &&
            warn$2('v-bind without argument expects an Object or Array value', this);
          }
          else {
            if (isArray(value)) {
              value = toObject(value);
            }
            var hash = void 0;
            var _loop_1 = function (key) {
              if (key === 'class' || key === 'style' || isReservedAttribute(key)) {
                hash = data;
              }
              else {
                var type = data.attrs && data.attrs.type;
                hash =
                    asProp || config.mustUseProp(tag, type, key)
                        ? data.domProps || (data.domProps = {})
                        : data.attrs || (data.attrs = {});
              }
              var camelizedKey = camelize(key);
              var hyphenatedKey = hyphenate(key);
              if (!(camelizedKey in hash) && !(hyphenatedKey in hash)) {
                hash[key] = value[key];
                if (isSync) {
                  var on = data.on || (data.on = {});
                  on["update:".concat(key)] = function ($event) {
                    value[key] = $event;
                  };
                }
              }
            };
            for (var key in value) {
              _loop_1(key);
            }
          }
        }
        return data;
      }

      /**
       * Runtime helper for rendering static trees.
       */
      function renderStatic(index, isInFor) {
        var cached = this._staticTrees || (this._staticTrees = []);
        var tree = cached[index];
        // if has already-rendered static tree and not inside v-for,
        // we can reuse the same tree.
        if (tree && !isInFor) {
          return tree;
        }
        // otherwise, render a fresh tree.
        tree = cached[index] = this.$options.staticRenderFns[index].call(this._renderProxy, this._c, this // for render fns generated for functional component templates
        );
        markStatic$1(tree, "__static__".concat(index), false);
        return tree;
      }
      /**
       * Runtime helper for v-once.
       * Effectively it means marking the node as static with a unique key.
       */
      function markOnce(tree, index, key) {
        markStatic$1(tree, "__once__".concat(index).concat(key ? "_".concat(key) : ""), true);
        return tree;
      }
      function markStatic$1(tree, key, isOnce) {
        if (isArray(tree)) {
          for (var i = 0; i < tree.length; i++) {
            if (tree[i] && typeof tree[i] !== 'string') {
              markStaticNode(tree[i], "".concat(key, "_").concat(i), isOnce);
            }
          }
        }
        else {
          markStaticNode(tree, key, isOnce);
        }
      }
      function markStaticNode(node, key, isOnce) {
        node.isStatic = true;
        node.key = key;
        node.isOnce = isOnce;
      }

      function bindObjectListeners(data, value) {
        if (value) {
          if (!isPlainObject(value)) {
            true && warn$2('v-on without argument expects an Object value', this);
          }
          else {
            var on = (data.on = data.on ? extend({}, data.on) : {});
            for (var key in value) {
              var existing = on[key];
              var ours = value[key];
              on[key] = existing ? [].concat(existing, ours) : ours;
            }
          }
        }
        return data;
      }

      function resolveScopedSlots(fns, res,
                                  // the following are added in 2.6
                                  hasDynamicKeys, contentHashKey) {
        res = res || { $stable: !hasDynamicKeys };
        for (var i = 0; i < fns.length; i++) {
          var slot = fns[i];
          if (isArray(slot)) {
            resolveScopedSlots(slot, res, hasDynamicKeys);
          }
          else if (slot) {
            // marker for reverse proxying v-slot without scope on this.$slots
            // @ts-expect-error
            if (slot.proxy) {
              // @ts-expect-error
              slot.fn.proxy = true;
            }
            res[slot.key] = slot.fn;
          }
        }
        if (contentHashKey) {
          res.$key = contentHashKey;
        }
        return res;
      }

// helper to process dynamic keys for dynamic arguments in v-bind and v-on.
      function bindDynamicKeys(baseObj, values) {
        for (var i = 0; i < values.length; i += 2) {
          var key = values[i];
          if (typeof key === 'string' && key) {
            baseObj[values[i]] = values[i + 1];
          }
          else if ( true && key !== '' && key !== null) {
            // null is a special value for explicitly removing a binding
            warn$2("Invalid value for dynamic directive argument (expected string or null): ".concat(key), this);
          }
        }
        return baseObj;
      }
// helper to dynamically append modifier runtime markers to event names.
// ensure only append when value is already string, otherwise it will be cast
// to string and cause the type check to miss.
      function prependModifier(value, symbol) {
        return typeof value === 'string' ? symbol + value : value;
      }

      function installRenderHelpers(target) {
        target._o = markOnce;
        target._n = toNumber;
        target._s = toString;
        target._l = renderList;
        target._t = renderSlot;
        target._q = looseEqual;
        target._i = looseIndexOf;
        target._m = renderStatic;
        target._f = resolveFilter;
        target._k = checkKeyCodes;
        target._b = bindObjectProps;
        target._v = createTextVNode;
        target._e = createEmptyVNode;
        target._u = resolveScopedSlots;
        target._g = bindObjectListeners;
        target._d = bindDynamicKeys;
        target._p = prependModifier;
      }

      /**
       * Runtime helper for resolving raw children VNodes into a slot object.
       */
      function resolveSlots(children, context) {
        if (!children || !children.length) {
          return {};
        }
        var slots = {};
        for (var i = 0, l = children.length; i < l; i++) {
          var child = children[i];
          var data = child.data;
          // remove slot attribute if the node is resolved as a Vue slot node
          if (data && data.attrs && data.attrs.slot) {
            delete data.attrs.slot;
          }
          // named slots should only be respected if the vnode was rendered in the
          // same context.
          if ((child.context === context || child.fnContext === context) &&
              data &&
              data.slot != null) {
            var name_1 = data.slot;
            var slot = slots[name_1] || (slots[name_1] = []);
            if (child.tag === 'template') {
              slot.push.apply(slot, child.children || []);
            }
            else {
              slot.push(child);
            }
          }
          else {
            (slots.default || (slots.default = [])).push(child);
          }
        }
        // ignore slots that contains only whitespace
        for (var name_2 in slots) {
          if (slots[name_2].every(isWhitespace)) {
            delete slots[name_2];
          }
        }
        return slots;
      }
      function isWhitespace(node) {
        return (node.isComment && !node.asyncFactory) || node.text === ' ';
      }

      function isAsyncPlaceholder(node) {
        // @ts-expect-error not really boolean type
        return node.isComment && node.asyncFactory;
      }

      function normalizeScopedSlots(ownerVm, scopedSlots, normalSlots, prevScopedSlots) {
        var res;
        var hasNormalSlots = Object.keys(normalSlots).length > 0;
        var isStable = scopedSlots ? !!scopedSlots.$stable : !hasNormalSlots;
        var key = scopedSlots && scopedSlots.$key;
        if (!scopedSlots) {
          res = {};
        }
        else if (scopedSlots._normalized) {
          // fast path 1: child component re-render only, parent did not change
          return scopedSlots._normalized;
        }
        else if (isStable &&
            prevScopedSlots &&
            prevScopedSlots !== emptyObject &&
            key === prevScopedSlots.$key &&
            !hasNormalSlots &&
            !prevScopedSlots.$hasNormal) {
          // fast path 2: stable scoped slots w/ no normal slots to proxy,
          // only need to normalize once
          return prevScopedSlots;
        }
        else {
          res = {};
          for (var key_1 in scopedSlots) {
            if (scopedSlots[key_1] && key_1[0] !== '$') {
              res[key_1] = normalizeScopedSlot(ownerVm, normalSlots, key_1, scopedSlots[key_1]);
            }
          }
        }
        // expose normal slots on scopedSlots
        for (var key_2 in normalSlots) {
          if (!(key_2 in res)) {
            res[key_2] = proxyNormalSlot(normalSlots, key_2);
          }
        }
        // avoriaz seems to mock a non-extensible $scopedSlots object
        // and when that is passed down this would cause an error
        if (scopedSlots && Object.isExtensible(scopedSlots)) {
          scopedSlots._normalized = res;
        }
        def(res, '$stable', isStable);
        def(res, '$key', key);
        def(res, '$hasNormal', hasNormalSlots);
        return res;
      }
      function normalizeScopedSlot(vm, normalSlots, key, fn) {
        var normalized = function () {
          var cur = currentInstance;
          setCurrentInstance(vm);
          var res = arguments.length ? fn.apply(null, arguments) : fn({});
          res =
              res && typeof res === 'object' && !isArray(res)
                  ? [res] // single vnode
                  : normalizeChildren(res);
          var vnode = res && res[0];
          setCurrentInstance(cur);
          return res &&
          (!vnode ||
              (res.length === 1 && vnode.isComment && !isAsyncPlaceholder(vnode))) // #9658, #10391
              ? undefined
              : res;
        };
        // this is a slot using the new v-slot syntax without scope. although it is
        // compiled as a scoped slot, render fn users would expect it to be present
        // on this.$slots because the usage is semantically a normal slot.
        if (fn.proxy) {
          Object.defineProperty(normalSlots, key, {
            get: normalized,
            enumerable: true,
            configurable: true
          });
        }
        return normalized;
      }
      function proxyNormalSlot(slots, key) {
        return function () { return slots[key]; };
      }

      function initSetup(vm) {
        var options = vm.$options;
        var setup = options.setup;
        if (setup) {
          var ctx = (vm._setupContext = createSetupContext(vm));
          setCurrentInstance(vm);
          pushTarget();
          var setupResult = invokeWithErrorHandling(setup, null, [vm._props || shallowReactive({}), ctx], vm, "setup");
          popTarget();
          setCurrentInstance();
          if (isFunction(setupResult)) {
            // render function
            // @ts-ignore
            options.render = setupResult;
          }
          else if (isObject(setupResult)) {
            // bindings
            if ( true && setupResult instanceof VNode) {
              warn$2("setup() should not return VNodes directly - " +
                  "return a render function instead.");
            }
            vm._setupState = setupResult;
            // __sfc indicates compiled bindings from <script setup>
            if (!setupResult.__sfc) {
              for (var key in setupResult) {
                if (!isReserved(key)) {
                  proxyWithRefUnwrap(vm, setupResult, key);
                }
                else if (true) {
                  warn$2("Avoid using variables that start with _ or $ in setup().");
                }
              }
            }
            else {
              // exposed for compiled render fn
              var proxy = (vm._setupProxy = {});
              for (var key in setupResult) {
                if (key !== '__sfc') {
                  proxyWithRefUnwrap(proxy, setupResult, key);
                }
              }
            }
          }
          else if ( true && setupResult !== undefined) {
            warn$2("setup() should return an object. Received: ".concat(setupResult === null ? 'null' : typeof setupResult));
          }
        }
      }
      function createSetupContext(vm) {
        var exposeCalled = false;
        return {
          get attrs() {
            if (!vm._attrsProxy) {
              var proxy = (vm._attrsProxy = {});
              def(proxy, '_v_attr_proxy', true);
              syncSetupProxy(proxy, vm.$attrs, emptyObject, vm, '$attrs');
            }
            return vm._attrsProxy;
          },
          get listeners() {
            if (!vm._listenersProxy) {
              var proxy = (vm._listenersProxy = {});
              syncSetupProxy(proxy, vm.$listeners, emptyObject, vm, '$listeners');
            }
            return vm._listenersProxy;
          },
          get slots() {
            return initSlotsProxy(vm);
          },
          emit: bind$1(vm.$emit, vm),
          expose: function (exposed) {
            if (true) {
              if (exposeCalled) {
                warn$2("expose() should be called only once per setup().", vm);
              }
              exposeCalled = true;
            }
            if (exposed) {
              Object.keys(exposed).forEach(function (key) {
                return proxyWithRefUnwrap(vm, exposed, key);
              });
            }
          }
        };
      }
      function syncSetupProxy(to, from, prev, instance, type) {
        var changed = false;
        for (var key in from) {
          if (!(key in to)) {
            changed = true;
            defineProxyAttr(to, key, instance, type);
          }
          else if (from[key] !== prev[key]) {
            changed = true;
          }
        }
        for (var key in to) {
          if (!(key in from)) {
            changed = true;
            delete to[key];
          }
        }
        return changed;
      }
      function defineProxyAttr(proxy, key, instance, type) {
        Object.defineProperty(proxy, key, {
          enumerable: true,
          configurable: true,
          get: function () {
            return instance[type][key];
          }
        });
      }
      function initSlotsProxy(vm) {
        if (!vm._slotsProxy) {
          syncSetupSlots((vm._slotsProxy = {}), vm.$scopedSlots);
        }
        return vm._slotsProxy;
      }
      function syncSetupSlots(to, from) {
        for (var key in from) {
          to[key] = from[key];
        }
        for (var key in to) {
          if (!(key in from)) {
            delete to[key];
          }
        }
      }
      /**
       * @internal use manual type def because public setup context type relies on
       * legacy VNode types
       */
      function useSlots() {
        return getContext().slots;
      }
      /**
       * @internal use manual type def because public setup context type relies on
       * legacy VNode types
       */
      function useAttrs() {
        return getContext().attrs;
      }
      /**
       * Vue 2 only
       * @internal use manual type def because public setup context type relies on
       * legacy VNode types
       */
      function useListeners() {
        return getContext().listeners;
      }
      function getContext() {
        if ( true && !currentInstance) {
          warn$2("useContext() called without active instance.");
        }
        var vm = currentInstance;
        return vm._setupContext || (vm._setupContext = createSetupContext(vm));
      }
      /**
       * Runtime helper for merging default declarations. Imported by compiled code
       * only.
       * @internal
       */
      function mergeDefaults(raw, defaults) {
        var props = isArray(raw)
            ? raw.reduce(function (normalized, p) { return ((normalized[p] = {}), normalized); }, {})
            : raw;
        for (var key in defaults) {
          var opt = props[key];
          if (opt) {
            if (isArray(opt) || isFunction(opt)) {
              props[key] = { type: opt, default: defaults[key] };
            }
            else {
              opt.default = defaults[key];
            }
          }
          else if (opt === null) {
            props[key] = { default: defaults[key] };
          }
          else if (true) {
            warn$2("props default key \"".concat(key, "\" has no corresponding declaration."));
          }
        }
        return props;
      }

      function initRender(vm) {
        vm._vnode = null; // the root of the child tree
        vm._staticTrees = null; // v-once cached trees
        var options = vm.$options;
        var parentVnode = (vm.$vnode = options._parentVnode); // the placeholder node in parent tree
        var renderContext = parentVnode && parentVnode.context;
        vm.$slots = resolveSlots(options._renderChildren, renderContext);
        vm.$scopedSlots = parentVnode
            ? normalizeScopedSlots(vm.$parent, parentVnode.data.scopedSlots, vm.$slots)
            : emptyObject;
        // bind the createElement fn to this instance
        // so that we get proper render context inside it.
        // args order: tag, data, children, normalizationType, alwaysNormalize
        // internal version is used by render functions compiled from templates
        // @ts-expect-error
        vm._c = function (a, b, c, d) { return createElement$1(vm, a, b, c, d, false); };
        // normalization is always applied for the public version, used in
        // user-written render functions.
        // @ts-expect-error
        vm.$createElement = function (a, b, c, d) { return createElement$1(vm, a, b, c, d, true); };
        // $attrs & $listeners are exposed for easier HOC creation.
        // they need to be reactive so that HOCs using them are always updated
        var parentData = parentVnode && parentVnode.data;
        /* istanbul ignore else */
        if (true) {
          defineReactive(vm, '$attrs', (parentData && parentData.attrs) || emptyObject, function () {
            !isUpdatingChildComponent && warn$2("$attrs is readonly.", vm);
          }, true);
          defineReactive(vm, '$listeners', options._parentListeners || emptyObject, function () {
            !isUpdatingChildComponent && warn$2("$listeners is readonly.", vm);
          }, true);
        }
        else {}
      }
      var currentRenderingInstance = null;
      function renderMixin(Vue) {
        // install runtime convenience helpers
        installRenderHelpers(Vue.prototype);
        Vue.prototype.$nextTick = function (fn) {
          return nextTick(fn, this);
        };
        Vue.prototype._render = function () {
          var vm = this;
          var _a = vm.$options, render = _a.render, _parentVnode = _a._parentVnode;
          if (_parentVnode && vm._isMounted) {
            vm.$scopedSlots = normalizeScopedSlots(vm.$parent, _parentVnode.data.scopedSlots, vm.$slots, vm.$scopedSlots);
            if (vm._slotsProxy) {
              syncSetupSlots(vm._slotsProxy, vm.$scopedSlots);
            }
          }
          // set parent vnode. this allows render functions to have access
          // to the data on the placeholder node.
          vm.$vnode = _parentVnode;
          // render self
          var vnode;
          try {
            // There's no need to maintain a stack because all render fns are called
            // separately from one another. Nested component's render fns are called
            // when parent component is patched.
            setCurrentInstance(vm);
            currentRenderingInstance = vm;
            vnode = render.call(vm._renderProxy, vm.$createElement);
          }
          catch (e) {
            handleError(e, vm, "render");
            // return error render result,
            // or previous vnode to prevent render error causing blank component
            /* istanbul ignore else */
            if ( true && vm.$options.renderError) {
              try {
                vnode = vm.$options.renderError.call(vm._renderProxy, vm.$createElement, e);
              }
              catch (e) {
                handleError(e, vm, "renderError");
                vnode = vm._vnode;
              }
            }
            else {
              vnode = vm._vnode;
            }
          }
          finally {
            currentRenderingInstance = null;
            setCurrentInstance();
          }
          // if the returned array contains only a single node, allow it
          if (isArray(vnode) && vnode.length === 1) {
            vnode = vnode[0];
          }
          // return empty vnode in case the render function errored out
          if (!(vnode instanceof VNode)) {
            if ( true && isArray(vnode)) {
              warn$2('Multiple root nodes returned from render function. Render function ' +
                  'should return a single root node.', vm);
            }
            vnode = createEmptyVNode();
          }
          // set parent
          vnode.parent = _parentVnode;
          return vnode;
        };
      }

      function ensureCtor(comp, base) {
        if (comp.__esModule || (hasSymbol && comp[Symbol.toStringTag] === 'Module')) {
          comp = comp.default;
        }
        return isObject(comp) ? base.extend(comp) : comp;
      }
      function createAsyncPlaceholder(factory, data, context, children, tag) {
        var node = createEmptyVNode();
        node.asyncFactory = factory;
        node.asyncMeta = { data: data, context: context, children: children, tag: tag };
        return node;
      }
      function resolveAsyncComponent(factory, baseCtor) {
        if (isTrue(factory.error) && isDef(factory.errorComp)) {
          return factory.errorComp;
        }
        if (isDef(factory.resolved)) {
          return factory.resolved;
        }
        var owner = currentRenderingInstance;
        if (owner && isDef(factory.owners) && factory.owners.indexOf(owner) === -1) {
          // already pending
          factory.owners.push(owner);
        }
        if (isTrue(factory.loading) && isDef(factory.loadingComp)) {
          return factory.loadingComp;
        }
        if (owner && !isDef(factory.owners)) {
          var owners_1 = (factory.owners = [owner]);
          var sync_1 = true;
          var timerLoading_1 = null;
          var timerTimeout_1 = null;
          owner.$on('hook:destroyed', function () { return remove$2(owners_1, owner); });
          var forceRender_1 = function (renderCompleted) {
            for (var i = 0, l = owners_1.length; i < l; i++) {
              owners_1[i].$forceUpdate();
            }
            if (renderCompleted) {
              owners_1.length = 0;
              if (timerLoading_1 !== null) {
                clearTimeout(timerLoading_1);
                timerLoading_1 = null;
              }
              if (timerTimeout_1 !== null) {
                clearTimeout(timerTimeout_1);
                timerTimeout_1 = null;
              }
            }
          };
          var resolve = once(function (res) {
            // cache resolved
            factory.resolved = ensureCtor(res, baseCtor);
            // invoke callbacks only if this is not a synchronous resolve
            // (async resolves are shimmed as synchronous during SSR)
            if (!sync_1) {
              forceRender_1(true);
            }
            else {
              owners_1.length = 0;
            }
          });
          var reject_1 = once(function (reason) {
            true &&
            warn$2("Failed to resolve async component: ".concat(String(factory)) +
                (reason ? "\nReason: ".concat(reason) : ''));
            if (isDef(factory.errorComp)) {
              factory.error = true;
              forceRender_1(true);
            }
          });
          var res_1 = factory(resolve, reject_1);
          if (isObject(res_1)) {
            if (isPromise(res_1)) {
              // () => Promise
              if (isUndef(factory.resolved)) {
                res_1.then(resolve, reject_1);
              }
            }
            else if (isPromise(res_1.component)) {
              res_1.component.then(resolve, reject_1);
              if (isDef(res_1.error)) {
                factory.errorComp = ensureCtor(res_1.error, baseCtor);
              }
              if (isDef(res_1.loading)) {
                factory.loadingComp = ensureCtor(res_1.loading, baseCtor);
                if (res_1.delay === 0) {
                  factory.loading = true;
                }
                else {
                  // @ts-expect-error NodeJS timeout type
                  timerLoading_1 = setTimeout(function () {
                    timerLoading_1 = null;
                    if (isUndef(factory.resolved) && isUndef(factory.error)) {
                      factory.loading = true;
                      forceRender_1(false);
                    }
                  }, res_1.delay || 200);
                }
              }
              if (isDef(res_1.timeout)) {
                // @ts-expect-error NodeJS timeout type
                timerTimeout_1 = setTimeout(function () {
                  timerTimeout_1 = null;
                  if (isUndef(factory.resolved)) {
                    reject_1( true ? "timeout (".concat(res_1.timeout, "ms)") : 0);
                  }
                }, res_1.timeout);
              }
            }
          }
          sync_1 = false;
          // return in case resolved synchronously
          return factory.loading ? factory.loadingComp : factory.resolved;
        }
      }

      function getFirstComponentChild(children) {
        if (isArray(children)) {
          for (var i = 0; i < children.length; i++) {
            var c = children[i];
            if (isDef(c) && (isDef(c.componentOptions) || isAsyncPlaceholder(c))) {
              return c;
            }
          }
        }
      }

      function initEvents(vm) {
        vm._events = Object.create(null);
        vm._hasHookEvent = false;
        // init parent attached events
        var listeners = vm.$options._parentListeners;
        if (listeners) {
          updateComponentListeners(vm, listeners);
        }
      }
      var target$1;
      function add$1(event, fn) {
        target$1.$on(event, fn);
      }
      function remove$1(event, fn) {
        target$1.$off(event, fn);
      }
      function createOnceHandler$1(event, fn) {
        var _target = target$1;
        return function onceHandler() {
          var res = fn.apply(null, arguments);
          if (res !== null) {
            _target.$off(event, onceHandler);
          }
        };
      }
      function updateComponentListeners(vm, listeners, oldListeners) {
        target$1 = vm;
        updateListeners(listeners, oldListeners || {}, add$1, remove$1, createOnceHandler$1, vm);
        target$1 = undefined;
      }
      function eventsMixin(Vue) {
        var hookRE = /^hook:/;
        Vue.prototype.$on = function (event, fn) {
          var vm = this;
          if (isArray(event)) {
            for (var i = 0, l = event.length; i < l; i++) {
              vm.$on(event[i], fn);
            }
          }
          else {
            (vm._events[event] || (vm._events[event] = [])).push(fn);
            // optimize hook:event cost by using a boolean flag marked at registration
            // instead of a hash lookup
            if (hookRE.test(event)) {
              vm._hasHookEvent = true;
            }
          }
          return vm;
        };
        Vue.prototype.$once = function (event, fn) {
          var vm = this;
          function on() {
            vm.$off(event, on);
            fn.apply(vm, arguments);
          }
          on.fn = fn;
          vm.$on(event, on);
          return vm;
        };
        Vue.prototype.$off = function (event, fn) {
          var vm = this;
          // all
          if (!arguments.length) {
            vm._events = Object.create(null);
            return vm;
          }
          // array of events
          if (isArray(event)) {
            for (var i_1 = 0, l = event.length; i_1 < l; i_1++) {
              vm.$off(event[i_1], fn);
            }
            return vm;
          }
          // specific event
          var cbs = vm._events[event];
          if (!cbs) {
            return vm;
          }
          if (!fn) {
            vm._events[event] = null;
            return vm;
          }
          // specific handler
          var cb;
          var i = cbs.length;
          while (i--) {
            cb = cbs[i];
            if (cb === fn || cb.fn === fn) {
              cbs.splice(i, 1);
              break;
            }
          }
          return vm;
        };
        Vue.prototype.$emit = function (event) {
          var vm = this;
          if (true) {
            var lowerCaseEvent = event.toLowerCase();
            if (lowerCaseEvent !== event && vm._events[lowerCaseEvent]) {
              tip("Event \"".concat(lowerCaseEvent, "\" is emitted in component ") +
                  "".concat(formatComponentName(vm), " but the handler is registered for \"").concat(event, "\". ") +
                  "Note that HTML attributes are case-insensitive and you cannot use " +
                  "v-on to listen to camelCase events when using in-DOM templates. " +
                  "You should probably use \"".concat(hyphenate(event), "\" instead of \"").concat(event, "\"."));
            }
          }
          var cbs = vm._events[event];
          if (cbs) {
            cbs = cbs.length > 1 ? toArray(cbs) : cbs;
            var args = toArray(arguments, 1);
            var info = "event handler for \"".concat(event, "\"");
            for (var i = 0, l = cbs.length; i < l; i++) {
              invokeWithErrorHandling(cbs[i], vm, args, vm, info);
            }
          }
          return vm;
        };
      }

      var activeInstance = null;
      var isUpdatingChildComponent = false;
      function setActiveInstance(vm) {
        var prevActiveInstance = activeInstance;
        activeInstance = vm;
        return function () {
          activeInstance = prevActiveInstance;
        };
      }
      function initLifecycle(vm) {
        var options = vm.$options;
        // locate first non-abstract parent
        var parent = options.parent;
        if (parent && !options.abstract) {
          while (parent.$options.abstract && parent.$parent) {
            parent = parent.$parent;
          }
          parent.$children.push(vm);
        }
        vm.$parent = parent;
        vm.$root = parent ? parent.$root : vm;
        vm.$children = [];
        vm.$refs = {};
        vm._provided = parent ? parent._provided : Object.create(null);
        vm._watcher = null;
        vm._inactive = null;
        vm._directInactive = false;
        vm._isMounted = false;
        vm._isDestroyed = false;
        vm._isBeingDestroyed = false;
      }
      function lifecycleMixin(Vue) {
        Vue.prototype._update = function (vnode, hydrating) {
          var vm = this;
          var prevEl = vm.$el;
          var prevVnode = vm._vnode;
          var restoreActiveInstance = setActiveInstance(vm);
          vm._vnode = vnode;
          // Vue.prototype.__patch__ is injected in entry points
          // based on the rendering backend used.
          if (!prevVnode) {
            // initial render
            vm.$el = vm.__patch__(vm.$el, vnode, hydrating, false /* removeOnly */);
          }
          else {
            // updates
            vm.$el = vm.__patch__(prevVnode, vnode);
          }
          restoreActiveInstance();
          // update __vue__ reference
          if (prevEl) {
            prevEl.__vue__ = null;
          }
          if (vm.$el) {
            vm.$el.__vue__ = vm;
          }
          // if parent is an HOC, update its $el as well
          var wrapper = vm;
          while (wrapper &&
          wrapper.$vnode &&
          wrapper.$parent &&
          wrapper.$vnode === wrapper.$parent._vnode) {
            wrapper.$parent.$el = wrapper.$el;
            wrapper = wrapper.$parent;
          }
          // updated hook is called by the scheduler to ensure that children are
          // updated in a parent's updated hook.
        };
        Vue.prototype.$forceUpdate = function () {
          var vm = this;
          if (vm._watcher) {
            vm._watcher.update();
          }
        };
        Vue.prototype.$destroy = function () {
          var vm = this;
          if (vm._isBeingDestroyed) {
            return;
          }
          callHook$1(vm, 'beforeDestroy');
          vm._isBeingDestroyed = true;
          // remove self from parent
          var parent = vm.$parent;
          if (parent && !parent._isBeingDestroyed && !vm.$options.abstract) {
            remove$2(parent.$children, vm);
          }
          // teardown scope. this includes both the render watcher and other
          // watchers created
          vm._scope.stop();
          // remove reference from data ob
          // frozen object may not have observer.
          if (vm._data.__ob__) {
            vm._data.__ob__.vmCount--;
          }
          // call the last hook...
          vm._isDestroyed = true;
          // invoke destroy hooks on current rendered tree
          vm.__patch__(vm._vnode, null);
          // fire destroyed hook
          callHook$1(vm, 'destroyed');
          // turn off all instance listeners.
          vm.$off();
          // remove __vue__ reference
          if (vm.$el) {
            vm.$el.__vue__ = null;
          }
          // release circular reference (#6759)
          if (vm.$vnode) {
            vm.$vnode.parent = null;
          }
        };
      }
      function mountComponent(vm, el, hydrating) {
        vm.$el = el;
        if (!vm.$options.render) {
          // @ts-expect-error invalid type
          vm.$options.render = createEmptyVNode;
          if (true) {
            /* istanbul ignore if */
            if ((vm.$options.template && vm.$options.template.charAt(0) !== '#') ||
                vm.$options.el ||
                el) {
              warn$2('You are using the runtime-only build of Vue where the template ' +
                  'compiler is not available. Either pre-compile the templates into ' +
                  'render functions, or use the compiler-included build.', vm);
            }
            else {
              warn$2('Failed to mount component: template or render function not defined.', vm);
            }
          }
        }
        callHook$1(vm, 'beforeMount');
        var updateComponent;
        /* istanbul ignore if */
        if ( true && config.performance && mark) {
          updateComponent = function () {
            var name = vm._name;
            var id = vm._uid;
            var startTag = "vue-perf-start:".concat(id);
            var endTag = "vue-perf-end:".concat(id);
            mark(startTag);
            var vnode = vm._render();
            mark(endTag);
            measure("vue ".concat(name, " render"), startTag, endTag);
            mark(startTag);
            vm._update(vnode, hydrating);
            mark(endTag);
            measure("vue ".concat(name, " patch"), startTag, endTag);
          };
        }
        else {
          updateComponent = function () {
            vm._update(vm._render(), hydrating);
          };
        }
        var watcherOptions = {
          before: function () {
            if (vm._isMounted && !vm._isDestroyed) {
              callHook$1(vm, 'beforeUpdate');
            }
          }
        };
        if (true) {
          watcherOptions.onTrack = function (e) { return callHook$1(vm, 'renderTracked', [e]); };
          watcherOptions.onTrigger = function (e) { return callHook$1(vm, 'renderTriggered', [e]); };
        }
        // we set this to vm._watcher inside the watcher's constructor
        // since the watcher's initial patch may call $forceUpdate (e.g. inside child
        // component's mounted hook), which relies on vm._watcher being already defined
        new Watcher(vm, updateComponent, noop, watcherOptions, true /* isRenderWatcher */);
        hydrating = false;
        // flush buffer for flush: "pre" watchers queued in setup()
        var preWatchers = vm._preWatchers;
        if (preWatchers) {
          for (var i = 0; i < preWatchers.length; i++) {
            preWatchers[i].run();
          }
        }
        // manually mounted instance, call mounted on self
        // mounted is called for render-created child components in its inserted hook
        if (vm.$vnode == null) {
          vm._isMounted = true;
          callHook$1(vm, 'mounted');
        }
        return vm;
      }
      function updateChildComponent(vm, propsData, listeners, parentVnode, renderChildren) {
        if (true) {
          isUpdatingChildComponent = true;
        }
        // determine whether component has slot children
        // we need to do this before overwriting $options._renderChildren.
        // check if there are dynamic scopedSlots (hand-written or compiled but with
        // dynamic slot names). Static scoped slots compiled from template has the
        // "$stable" marker.
        var newScopedSlots = parentVnode.data.scopedSlots;
        var oldScopedSlots = vm.$scopedSlots;
        var hasDynamicScopedSlot = !!((newScopedSlots && !newScopedSlots.$stable) ||
            (oldScopedSlots !== emptyObject && !oldScopedSlots.$stable) ||
            (newScopedSlots && vm.$scopedSlots.$key !== newScopedSlots.$key) ||
            (!newScopedSlots && vm.$scopedSlots.$key));
        // Any static slot children from the parent may have changed during parent's
        // update. Dynamic scoped slots may also have changed. In such cases, a forced
        // update is necessary to ensure correctness.
        var needsForceUpdate = !!(renderChildren || // has new static slots
            vm.$options._renderChildren || // has old static slots
            hasDynamicScopedSlot);
        var prevVNode = vm.$vnode;
        vm.$options._parentVnode = parentVnode;
        vm.$vnode = parentVnode; // update vm's placeholder node without re-render
        if (vm._vnode) {
          // update child tree's parent
          vm._vnode.parent = parentVnode;
        }
        vm.$options._renderChildren = renderChildren;
        // update $attrs and $listeners hash
        // these are also reactive so they may trigger child update if the child
        // used them during render
        var attrs = parentVnode.data.attrs || emptyObject;
        if (vm._attrsProxy) {
          // force update if attrs are accessed and has changed since it may be
          // passed to a child component.
          if (syncSetupProxy(vm._attrsProxy, attrs, (prevVNode.data && prevVNode.data.attrs) || emptyObject, vm, '$attrs')) {
            needsForceUpdate = true;
          }
        }
        vm.$attrs = attrs;
        // update listeners
        listeners = listeners || emptyObject;
        var prevListeners = vm.$options._parentListeners;
        if (vm._listenersProxy) {
          syncSetupProxy(vm._listenersProxy, listeners, prevListeners || emptyObject, vm, '$listeners');
        }
        vm.$listeners = vm.$options._parentListeners = listeners;
        updateComponentListeners(vm, listeners, prevListeners);
        // update props
        if (propsData && vm.$options.props) {
          toggleObserving(false);
          var props = vm._props;
          var propKeys = vm.$options._propKeys || [];
          for (var i = 0; i < propKeys.length; i++) {
            var key = propKeys[i];
            var propOptions = vm.$options.props; // wtf flow?
            props[key] = validateProp(key, propOptions, propsData, vm);
          }
          toggleObserving(true);
          // keep a copy of raw propsData
          vm.$options.propsData = propsData;
        }
        // resolve slots + force update if has children
        if (needsForceUpdate) {
          vm.$slots = resolveSlots(renderChildren, parentVnode.context);
          vm.$forceUpdate();
        }
        if (true) {
          isUpdatingChildComponent = false;
        }
      }
      function isInInactiveTree(vm) {
        while (vm && (vm = vm.$parent)) {
          if (vm._inactive)
            return true;
        }
        return false;
      }
      function activateChildComponent(vm, direct) {
        if (direct) {
          vm._directInactive = false;
          if (isInInactiveTree(vm)) {
            return;
          }
        }
        else if (vm._directInactive) {
          return;
        }
        if (vm._inactive || vm._inactive === null) {
          vm._inactive = false;
          for (var i = 0; i < vm.$children.length; i++) {
            activateChildComponent(vm.$children[i]);
          }
          callHook$1(vm, 'activated');
        }
      }
      function deactivateChildComponent(vm, direct) {
        if (direct) {
          vm._directInactive = true;
          if (isInInactiveTree(vm)) {
            return;
          }
        }
        if (!vm._inactive) {
          vm._inactive = true;
          for (var i = 0; i < vm.$children.length; i++) {
            deactivateChildComponent(vm.$children[i]);
          }
          callHook$1(vm, 'deactivated');
        }
      }
      function callHook$1(vm, hook, args, setContext) {
        if (setContext === void 0) { setContext = true; }
        // #7573 disable dep collection when invoking lifecycle hooks
        pushTarget();
        var prev = currentInstance;
        setContext && setCurrentInstance(vm);
        var handlers = vm.$options[hook];
        var info = "".concat(hook, " hook");
        if (handlers) {
          for (var i = 0, j = handlers.length; i < j; i++) {
            invokeWithErrorHandling(handlers[i], vm, args || null, vm, info);
          }
        }
        if (vm._hasHookEvent) {
          vm.$emit('hook:' + hook);
        }
        setContext && setCurrentInstance(prev);
        popTarget();
      }

      var MAX_UPDATE_COUNT = 100;
      var queue = [];
      var activatedChildren = [];
      var has = {};
      var circular = {};
      var waiting = false;
      var flushing = false;
      var index$1 = 0;
      /**
       * Reset the scheduler's state.
       */
      function resetSchedulerState() {
        index$1 = queue.length = activatedChildren.length = 0;
        has = {};
        if (true) {
          circular = {};
        }
        waiting = flushing = false;
      }
// Async edge case #6566 requires saving the timestamp when event listeners are
// attached. However, calling performance.now() has a perf overhead especially
// if the page has thousands of event listeners. Instead, we take a timestamp
// every time the scheduler flushes and use that for all event listeners
// attached during that flush.
      var currentFlushTimestamp = 0;
// Async edge case fix requires storing an event listener's attach timestamp.
      var getNow = Date.now;
// Determine what event timestamp the browser is using. Annoyingly, the
// timestamp can either be hi-res (relative to page load) or low-res
// (relative to UNIX epoch), so in order to compare time we have to use the
// same timestamp type when saving the flush timestamp.
// All IE versions use low-res event timestamps, and have problematic clock
// implementations (#9632)
      if (inBrowser && !isIE) {
        var performance_1 = window.performance;
        if (performance_1 &&
            typeof performance_1.now === 'function' &&
            getNow() > document.createEvent('Event').timeStamp) {
          // if the event timestamp, although evaluated AFTER the Date.now(), is
          // smaller than it, it means the event is using a hi-res timestamp,
          // and we need to use the hi-res version for event listener timestamps as
          // well.
          getNow = function () { return performance_1.now(); };
        }
      }
      var sortCompareFn = function (a, b) {
        if (a.post) {
          if (!b.post)
            return 1;
        }
        else if (b.post) {
          return -1;
        }
        return a.id - b.id;
      };
      /**
       * Flush both queues and run the watchers.
       */
      function flushSchedulerQueue() {
        currentFlushTimestamp = getNow();
        flushing = true;
        var watcher, id;
        // Sort queue before flush.
        // This ensures that:
        // 1. Components are updated from parent to child. (because parent is always
        //    created before the child)
        // 2. A component's user watchers are run before its render watcher (because
        //    user watchers are created before the render watcher)
        // 3. If a component is destroyed during a parent component's watcher run,
        //    its watchers can be skipped.
        queue.sort(sortCompareFn);
        // do not cache length because more watchers might be pushed
        // as we run existing watchers
        for (index$1 = 0; index$1 < queue.length; index$1++) {
          watcher = queue[index$1];
          if (watcher.before) {
            watcher.before();
          }
          id = watcher.id;
          has[id] = null;
          watcher.run();
          // in dev build, check and stop circular updates.
          if ( true && has[id] != null) {
            circular[id] = (circular[id] || 0) + 1;
            if (circular[id] > MAX_UPDATE_COUNT) {
              warn$2('You may have an infinite update loop ' +
                  (watcher.user
                      ? "in watcher with expression \"".concat(watcher.expression, "\"")
                      : "in a component render function."), watcher.vm);
              break;
            }
          }
        }
        // keep copies of post queues before resetting state
        var activatedQueue = activatedChildren.slice();
        var updatedQueue = queue.slice();
        resetSchedulerState();
        // call component updated and activated hooks
        callActivatedHooks(activatedQueue);
        callUpdatedHooks(updatedQueue);
        cleanupDeps();
        // devtool hook
        /* istanbul ignore if */
        if (devtools && config.devtools) {
          devtools.emit('flush');
        }
      }
      function callUpdatedHooks(queue) {
        var i = queue.length;
        while (i--) {
          var watcher = queue[i];
          var vm = watcher.vm;
          if (vm && vm._watcher === watcher && vm._isMounted && !vm._isDestroyed) {
            callHook$1(vm, 'updated');
          }
        }
      }
      /**
       * Queue a kept-alive component that was activated during patch.
       * The queue will be processed after the entire tree has been patched.
       */
      function queueActivatedComponent(vm) {
        // setting _inactive to false here so that a render function can
        // rely on checking whether it's in an inactive tree (e.g. router-view)
        vm._inactive = false;
        activatedChildren.push(vm);
      }
      function callActivatedHooks(queue) {
        for (var i = 0; i < queue.length; i++) {
          queue[i]._inactive = true;
          activateChildComponent(queue[i], true /* true */);
        }
      }
      /**
       * Push a watcher into the watcher queue.
       * Jobs with duplicate IDs will be skipped unless it's
       * pushed when the queue is being flushed.
       */
      function queueWatcher(watcher) {
        var id = watcher.id;
        if (has[id] != null) {
          return;
        }
        if (watcher === Dep.target && watcher.noRecurse) {
          return;
        }
        has[id] = true;
        if (!flushing) {
          queue.push(watcher);
        }
        else {
          // if already flushing, splice the watcher based on its id
          // if already past its id, it will be run next immediately.
          var i = queue.length - 1;
          while (i > index$1 && queue[i].id > watcher.id) {
            i--;
          }
          queue.splice(i + 1, 0, watcher);
        }
        // queue the flush
        if (!waiting) {
          waiting = true;
          if ( true && !config.async) {
            flushSchedulerQueue();
            return;
          }
          nextTick(flushSchedulerQueue);
        }
      }

      var WATCHER = "watcher";
      var WATCHER_CB = "".concat(WATCHER, " callback");
      var WATCHER_GETTER = "".concat(WATCHER, " getter");
      var WATCHER_CLEANUP = "".concat(WATCHER, " cleanup");
// Simple effect.
      function watchEffect(effect, options) {
        return doWatch(effect, null, options);
      }
      function watchPostEffect(effect, options) {
        return doWatch(effect, null, ( true
            ? __assign(__assign({}, options), { flush: 'post' }) : 0));
      }
      function watchSyncEffect(effect, options) {
        return doWatch(effect, null, ( true
            ? __assign(__assign({}, options), { flush: 'sync' }) : 0));
      }
// initial value for watchers to trigger on undefined initial values
      var INITIAL_WATCHER_VALUE = {};
// implementation
      function watch(source, cb, options) {
        if ( true && typeof cb !== 'function') {
          warn$2("`watch(fn, options?)` signature has been moved to a separate API. " +
              "Use `watchEffect(fn, options?)` instead. `watch` now only " +
              "supports `watch(source, cb, options?) signature.");
        }
        return doWatch(source, cb, options);
      }
      function doWatch(source, cb, _a) {
        var _b = _a === void 0 ? emptyObject : _a, immediate = _b.immediate, deep = _b.deep, _c = _b.flush, flush = _c === void 0 ? 'pre' : _c, onTrack = _b.onTrack, onTrigger = _b.onTrigger;
        if ( true && !cb) {
          if (immediate !== undefined) {
            warn$2("watch() \"immediate\" option is only respected when using the " +
                "watch(source, callback, options?) signature.");
          }
          if (deep !== undefined) {
            warn$2("watch() \"deep\" option is only respected when using the " +
                "watch(source, callback, options?) signature.");
          }
        }
        var warnInvalidSource = function (s) {
          warn$2("Invalid watch source: ".concat(s, ". A watch source can only be a getter/effect ") +
              "function, a ref, a reactive object, or an array of these types.");
        };
        var instance = currentInstance;
        var call = function (fn, type, args) {
          if (args === void 0) { args = null; }
          return invokeWithErrorHandling(fn, null, args, instance, type);
        };
        var getter;
        var forceTrigger = false;
        var isMultiSource = false;
        if (isRef(source)) {
          getter = function () { return source.value; };
          forceTrigger = isShallow(source);
        }
        else if (isReactive(source)) {
          getter = function () {
            source.__ob__.dep.depend();
            return source;
          };
          deep = true;
        }
        else if (isArray(source)) {
          isMultiSource = true;
          forceTrigger = source.some(function (s) { return isReactive(s) || isShallow(s); });
          getter = function () {
            return source.map(function (s) {
              if (isRef(s)) {
                return s.value;
              }
              else if (isReactive(s)) {
                return traverse(s);
              }
              else if (isFunction(s)) {
                return call(s, WATCHER_GETTER);
              }
              else {
                true && warnInvalidSource(s);
              }
            });
          };
        }
        else if (isFunction(source)) {
          if (cb) {
            // getter with cb
            getter = function () { return call(source, WATCHER_GETTER); };
          }
          else {
            // no cb -> simple effect
            getter = function () {
              if (instance && instance._isDestroyed) {
                return;
              }
              if (cleanup) {
                cleanup();
              }
              return call(source, WATCHER, [onCleanup]);
            };
          }
        }
        else {
          getter = noop;
          true && warnInvalidSource(source);
        }
        if (cb && deep) {
          var baseGetter_1 = getter;
          getter = function () { return traverse(baseGetter_1()); };
        }
        var cleanup;
        var onCleanup = function (fn) {
          cleanup = watcher.onStop = function () {
            call(fn, WATCHER_CLEANUP);
          };
        };
        // in SSR there is no need to setup an actual effect, and it should be noop
        // unless it's eager
        if (isServerRendering()) {
          // we will also not call the invalidate callback (+ runner is not set up)
          onCleanup = noop;
          if (!cb) {
            getter();
          }
          else if (immediate) {
            call(cb, WATCHER_CB, [
              getter(),
              isMultiSource ? [] : undefined,
              onCleanup
            ]);
          }
          return noop;
        }
        var watcher = new Watcher(currentInstance, getter, noop, {
          lazy: true
        });
        watcher.noRecurse = !cb;
        var oldValue = isMultiSource ? [] : INITIAL_WATCHER_VALUE;
        // overwrite default run
        watcher.run = function () {
          if (!watcher.active) {
            return;
          }
          if (cb) {
            // watch(source, cb)
            var newValue = watcher.get();
            if (deep ||
                forceTrigger ||
                (isMultiSource
                    ? newValue.some(function (v, i) {
                      return hasChanged(v, oldValue[i]);
                    })
                    : hasChanged(newValue, oldValue))) {
              // cleanup before running cb again
              if (cleanup) {
                cleanup();
              }
              call(cb, WATCHER_CB, [
                newValue,
                // pass undefined as the old value when it's changed for the first time
                oldValue === INITIAL_WATCHER_VALUE ? undefined : oldValue,
                onCleanup
              ]);
              oldValue = newValue;
            }
          }
          else {
            // watchEffect
            watcher.get();
          }
        };
        if (flush === 'sync') {
          watcher.update = watcher.run;
        }
        else if (flush === 'post') {
          watcher.post = true;
          watcher.update = function () { return queueWatcher(watcher); };
        }
        else {
          // pre
          watcher.update = function () {
            if (instance && instance === currentInstance && !instance._isMounted) {
              // pre-watcher triggered before
              var buffer = instance._preWatchers || (instance._preWatchers = []);
              if (buffer.indexOf(watcher) < 0)
                buffer.push(watcher);
            }
            else {
              queueWatcher(watcher);
            }
          };
        }
        if (true) {
          watcher.onTrack = onTrack;
          watcher.onTrigger = onTrigger;
        }
        // initial run
        if (cb) {
          if (immediate) {
            watcher.run();
          }
          else {
            oldValue = watcher.get();
          }
        }
        else if (flush === 'post' && instance) {
          instance.$once('hook:mounted', function () { return watcher.get(); });
        }
        else {
          watcher.get();
        }
        return function () {
          watcher.teardown();
        };
      }

      var activeEffectScope;
      var EffectScope = /** @class */ (function () {
        function EffectScope(detached) {
          if (detached === void 0) { detached = false; }
          this.detached = detached;
          /**
           * @internal
           */
          this.active = true;
          /**
           * @internal
           */
          this.effects = [];
          /**
           * @internal
           */
          this.cleanups = [];
          this.parent = activeEffectScope;
          if (!detached && activeEffectScope) {
            this.index =
                (activeEffectScope.scopes || (activeEffectScope.scopes = [])).push(this) - 1;
          }
        }
        EffectScope.prototype.run = function (fn) {
          if (this.active) {
            var currentEffectScope = activeEffectScope;
            try {
              activeEffectScope = this;
              return fn();
            }
            finally {
              activeEffectScope = currentEffectScope;
            }
          }
          else if (true) {
            warn$2("cannot run an inactive effect scope.");
          }
        };
        /**
         * This should only be called on non-detached scopes
         * @internal
         */
        EffectScope.prototype.on = function () {
          activeEffectScope = this;
        };
        /**
         * This should only be called on non-detached scopes
         * @internal
         */
        EffectScope.prototype.off = function () {
          activeEffectScope = this.parent;
        };
        EffectScope.prototype.stop = function (fromParent) {
          if (this.active) {
            var i = void 0, l = void 0;
            for (i = 0, l = this.effects.length; i < l; i++) {
              this.effects[i].teardown();
            }
            for (i = 0, l = this.cleanups.length; i < l; i++) {
              this.cleanups[i]();
            }
            if (this.scopes) {
              for (i = 0, l = this.scopes.length; i < l; i++) {
                this.scopes[i].stop(true);
              }
            }
            // nested scope, dereference from parent to avoid memory leaks
            if (!this.detached && this.parent && !fromParent) {
              // optimized O(1) removal
              var last = this.parent.scopes.pop();
              if (last && last !== this) {
                this.parent.scopes[this.index] = last;
                last.index = this.index;
              }
            }
            this.parent = undefined;
            this.active = false;
          }
        };
        return EffectScope;
      }());
      function effectScope(detached) {
        return new EffectScope(detached);
      }
      /**
       * @internal
       */
      function recordEffectScope(effect, scope) {
        if (scope === void 0) { scope = activeEffectScope; }
        if (scope && scope.active) {
          scope.effects.push(effect);
        }
      }
      function getCurrentScope() {
        return activeEffectScope;
      }
      function onScopeDispose(fn) {
        if (activeEffectScope) {
          activeEffectScope.cleanups.push(fn);
        }
        else if (true) {
          warn$2("onScopeDispose() is called when there is no active effect scope" +
              " to be associated with.");
        }
      }

      function provide(key, value) {
        if (!currentInstance) {
          if (true) {
            warn$2("provide() can only be used inside setup().");
          }
        }
        else {
          // TS doesn't allow symbol as index type
          resolveProvided(currentInstance)[key] = value;
        }
      }
      function resolveProvided(vm) {
        // by default an instance inherits its parent's provides object
        // but when it needs to provide values of its own, it creates its
        // own provides object using parent provides object as prototype.
        // this way in `inject` we can simply look up injections from direct
        // parent and let the prototype chain do the work.
        var existing = vm._provided;
        var parentProvides = vm.$parent && vm.$parent._provided;
        if (parentProvides === existing) {
          return (vm._provided = Object.create(parentProvides));
        }
        else {
          return existing;
        }
      }
      function inject(key, defaultValue, treatDefaultAsFactory) {
        if (treatDefaultAsFactory === void 0) { treatDefaultAsFactory = false; }
        // fallback to `currentRenderingInstance` so that this can be called in
        // a functional component
        var instance = currentInstance;
        if (instance) {
          // #2400
          // to support `app.use` plugins,
          // fallback to appContext's `provides` if the instance is at root
          var provides = instance.$parent && instance.$parent._provided;
          if (provides && key in provides) {
            // TS doesn't allow symbol as index type
            return provides[key];
          }
          else if (arguments.length > 1) {
            return treatDefaultAsFactory && isFunction(defaultValue)
                ? defaultValue.call(instance)
                : defaultValue;
          }
          else if (true) {
            warn$2("injection \"".concat(String(key), "\" not found."));
          }
        }
        else if (true) {
          warn$2("inject() can only be used inside setup() or functional components.");
        }
      }

      /**
       * @internal this function needs manual public type declaration because it relies
       * on previously manually authored types from Vue 2
       */
      function h(type, props, children) {
        if (!currentInstance) {
          true &&
          warn$2("globally imported h() can only be invoked when there is an active " +
              "component instance, e.g. synchronously in a component's render or setup function.");
        }
        return createElement$1(currentInstance, type, props, children, 2, true);
      }

      function handleError(err, vm, info) {
        // Deactivate deps tracking while processing error handler to avoid possible infinite rendering.
        // See: https://github.com/vuejs/vuex/issues/1505
        pushTarget();
        try {
          if (vm) {
            var cur = vm;
            while ((cur = cur.$parent)) {
              var hooks = cur.$options.errorCaptured;
              if (hooks) {
                for (var i = 0; i < hooks.length; i++) {
                  try {
                    var capture = hooks[i].call(cur, err, vm, info) === false;
                    if (capture)
                      return;
                  }
                  catch (e) {
                    globalHandleError(e, cur, 'errorCaptured hook');
                  }
                }
              }
            }
          }
          globalHandleError(err, vm, info);
        }
        finally {
          popTarget();
        }
      }
      function invokeWithErrorHandling(handler, context, args, vm, info) {
        var res;
        try {
          res = args ? handler.apply(context, args) : handler.call(context);
          if (res && !res._isVue && isPromise(res) && !res._handled) {
            res.catch(function (e) { return handleError(e, vm, info + " (Promise/async)"); });
            res._handled = true;
          }
        }
        catch (e) {
          handleError(e, vm, info);
        }
        return res;
      }
      function globalHandleError(err, vm, info) {
        if (config.errorHandler) {
          try {
            return config.errorHandler.call(null, err, vm, info);
          }
          catch (e) {
            // if the user intentionally throws the original error in the handler,
            // do not log it twice
            if (e !== err) {
              logError(e, null, 'config.errorHandler');
            }
          }
        }
        logError(err, vm, info);
      }
      function logError(err, vm, info) {
        if (true) {
          warn$2("Error in ".concat(info, ": \"").concat(err.toString(), "\""), vm);
        }
        /* istanbul ignore else */
        if (inBrowser && typeof console !== 'undefined') {
          console.error(err);
        }
        else {
          throw err;
        }
      }

      /* globals MutationObserver */
      var isUsingMicroTask = false;
      var callbacks = [];
      var pending = false;
      function flushCallbacks() {
        pending = false;
        var copies = callbacks.slice(0);
        callbacks.length = 0;
        for (var i = 0; i < copies.length; i++) {
          copies[i]();
        }
      }
// Here we have async deferring wrappers using microtasks.
// In 2.5 we used (macro) tasks (in combination with microtasks).
// However, it has subtle problems when state is changed right before repaint
// (e.g. #6813, out-in transitions).
// Also, using (macro) tasks in event handler would cause some weird behaviors
// that cannot be circumvented (e.g. #7109, #7153, #7546, #7834, #8109).
// So we now use microtasks everywhere, again.
// A major drawback of this tradeoff is that there are some scenarios
// where microtasks have too high a priority and fire in between supposedly
// sequential events (e.g. #4521, #6690, which have workarounds)
// or even between bubbling of the same event (#6566).
      var timerFunc;
// The nextTick behavior leverages the microtask queue, which can be accessed
// via either native Promise.then or MutationObserver.
// MutationObserver has wider support, however it is seriously bugged in
// UIWebView in iOS >= 9.3.3 when triggered in touch event handlers. It
// completely stops working after triggering a few times... so, if native
// Promise is available, we will use it:
      /* istanbul ignore next, $flow-disable-line */
      if (typeof Promise !== 'undefined' && isNative(Promise)) {
        var p_1 = Promise.resolve();
        timerFunc = function () {
          p_1.then(flushCallbacks);
          // In problematic UIWebViews, Promise.then doesn't completely break, but
          // it can get stuck in a weird state where callbacks are pushed into the
          // microtask queue but the queue isn't being flushed, until the browser
          // needs to do some other work, e.g. handle a timer. Therefore we can
          // "force" the microtask queue to be flushed by adding an empty timer.
          if (isIOS)
            setTimeout(noop);
        };
        isUsingMicroTask = true;
      }
      else if (!isIE &&
          typeof MutationObserver !== 'undefined' &&
          (isNative(MutationObserver) ||
              // PhantomJS and iOS 7.x
              MutationObserver.toString() === '[object MutationObserverConstructor]')) {
        // Use MutationObserver where native Promise is not available,
        // e.g. PhantomJS, iOS7, Android 4.4
        // (#6466 MutationObserver is unreliable in IE11)
        var counter_1 = 1;
        var observer = new MutationObserver(flushCallbacks);
        var textNode_1 = document.createTextNode(String(counter_1));
        observer.observe(textNode_1, {
          characterData: true
        });
        timerFunc = function () {
          counter_1 = (counter_1 + 1) % 2;
          textNode_1.data = String(counter_1);
        };
        isUsingMicroTask = true;
      }
      else if (typeof setImmediate !== 'undefined' && isNative(setImmediate)) {
        // Fallback to setImmediate.
        // Technically it leverages the (macro) task queue,
        // but it is still a better choice than setTimeout.
        timerFunc = function () {
          setImmediate(flushCallbacks);
        };
      }
      else {
        // Fallback to setTimeout.
        timerFunc = function () {
          setTimeout(flushCallbacks, 0);
        };
      }
      /**
       * @internal
       */
      function nextTick(cb, ctx) {
        var _resolve;
        callbacks.push(function () {
          if (cb) {
            try {
              cb.call(ctx);
            }
            catch (e) {
              handleError(e, ctx, 'nextTick');
            }
          }
          else if (_resolve) {
            _resolve(ctx);
          }
        });
        if (!pending) {
          pending = true;
          timerFunc();
        }
        // $flow-disable-line
        if (!cb && typeof Promise !== 'undefined') {
          return new Promise(function (resolve) {
            _resolve = resolve;
          });
        }
      }

      function useCssModule(name) {
        if (name === void 0) { name = '$style'; }
        /* istanbul ignore else */
        {
          if (!currentInstance) {
            true && warn$2("useCssModule must be called inside setup()");
            return emptyObject;
          }
          var mod = currentInstance[name];
          if (!mod) {
            true &&
            warn$2("Current instance does not have CSS module named \"".concat(name, "\"."));
            return emptyObject;
          }
          return mod;
        }
      }

      /**
       * Runtime helper for SFC's CSS variable injection feature.
       * @private
       */
      function useCssVars(getter) {
        if (!inBrowser && !false)
          return;
        var instance = currentInstance;
        if (!instance) {
          true &&
          warn$2("useCssVars is called without current active component instance.");
          return;
        }
        watchPostEffect(function () {
          var el = instance.$el;
          var vars = getter(instance, instance._setupProxy);
          if (el && el.nodeType === 1) {
            var style = el.style;
            for (var key in vars) {
              style.setProperty("--".concat(key), vars[key]);
            }
          }
        });
      }

      /**
       * v3-compatible async component API.
       * @internal the type is manually declared in <root>/types/v3-define-async-component.d.ts
       * because it relies on existing manual types
       */
      function defineAsyncComponent(source) {
        if (isFunction(source)) {
          source = { loader: source };
        }
        var loader = source.loader, loadingComponent = source.loadingComponent, errorComponent = source.errorComponent, _a = source.delay, delay = _a === void 0 ? 200 : _a, timeout = source.timeout, // undefined = never times out
            _b = source.suspensible, // undefined = never times out
            suspensible = _b === void 0 ? false : _b, // in Vue 3 default is true
            userOnError = source.onError;
        if ( true && suspensible) {
          warn$2("The suspensiblbe option for async components is not supported in Vue2. It is ignored.");
        }
        var pendingRequest = null;
        var retries = 0;
        var retry = function () {
          retries++;
          pendingRequest = null;
          return load();
        };
        var load = function () {
          var thisRequest;
          return (pendingRequest ||
              (thisRequest = pendingRequest =
                  loader()
                      .catch(function (err) {
                        err = err instanceof Error ? err : new Error(String(err));
                        if (userOnError) {
                          return new Promise(function (resolve, reject) {
                            var userRetry = function () { return resolve(retry()); };
                            var userFail = function () { return reject(err); };
                            userOnError(err, userRetry, userFail, retries + 1);
                          });
                        }
                        else {
                          throw err;
                        }
                      })
                      .then(function (comp) {
                        if (thisRequest !== pendingRequest && pendingRequest) {
                          return pendingRequest;
                        }
                        if ( true && !comp) {
                          warn$2("Async component loader resolved to undefined. " +
                              "If you are using retry(), make sure to return its return value.");
                        }
                        // interop module default
                        if (comp &&
                            (comp.__esModule || comp[Symbol.toStringTag] === 'Module')) {
                          comp = comp.default;
                        }
                        if ( true && comp && !isObject(comp) && !isFunction(comp)) {
                          throw new Error("Invalid async component load result: ".concat(comp));
                        }
                        return comp;
                      })));
        };
        return function () {
          var component = load();
          return {
            component: component,
            delay: delay,
            timeout: timeout,
            error: errorComponent,
            loading: loadingComponent
          };
        };
      }

      function createLifeCycle(hookName) {
        return function (fn, target) {
          if (target === void 0) { target = currentInstance; }
          if (!target) {
            true &&
            warn$2("".concat(formatName(hookName), " is called when there is no active component instance to be ") +
                "associated with. " +
                "Lifecycle injection APIs can only be used during execution of setup().");
            return;
          }
          return injectHook(target, hookName, fn);
        };
      }
      function formatName(name) {
        if (name === 'beforeDestroy') {
          name = 'beforeUnmount';
        }
        else if (name === 'destroyed') {
          name = 'unmounted';
        }
        return "on".concat(name[0].toUpperCase() + name.slice(1));
      }
      function injectHook(instance, hookName, fn) {
        var options = instance.$options;
        options[hookName] = mergeLifecycleHook(options[hookName], fn);
      }
      var onBeforeMount = createLifeCycle('beforeMount');
      var onMounted = createLifeCycle('mounted');
      var onBeforeUpdate = createLifeCycle('beforeUpdate');
      var onUpdated = createLifeCycle('updated');
      var onBeforeUnmount = createLifeCycle('beforeDestroy');
      var onUnmounted = createLifeCycle('destroyed');
      var onActivated = createLifeCycle('activated');
      var onDeactivated = createLifeCycle('deactivated');
      var onServerPrefetch = createLifeCycle('serverPrefetch');
      var onRenderTracked = createLifeCycle('renderTracked');
      var onRenderTriggered = createLifeCycle('renderTriggered');
      var injectErrorCapturedHook = createLifeCycle('errorCaptured');
      function onErrorCaptured(hook, target) {
        if (target === void 0) { target = currentInstance; }
        injectErrorCapturedHook(hook, target);
      }

      /**
       * Note: also update dist/vue.runtime.mjs when adding new exports to this file.
       */
      var version = '2.7.14';
      /**
       * @internal type is manually declared in <root>/types/v3-define-component.d.ts
       */
      function defineComponent(options) {
        return options;
      }

      var seenObjects = new _Set();
      /**
       * Recursively traverse an object to evoke all converted
       * getters, so that every nested property inside the object
       * is collected as a "deep" dependency.
       */
      function traverse(val) {
        _traverse(val, seenObjects);
        seenObjects.clear();
        return val;
      }
      function _traverse(val, seen) {
        var i, keys;
        var isA = isArray(val);
        if ((!isA && !isObject(val)) ||
            val.__v_skip /* ReactiveFlags.SKIP */ ||
            Object.isFrozen(val) ||
            val instanceof VNode) {
          return;
        }
        if (val.__ob__) {
          var depId = val.__ob__.dep.id;
          if (seen.has(depId)) {
            return;
          }
          seen.add(depId);
        }
        if (isA) {
          i = val.length;
          while (i--)
            _traverse(val[i], seen);
        }
        else if (isRef(val)) {
          _traverse(val.value, seen);
        }
        else {
          keys = Object.keys(val);
          i = keys.length;
          while (i--)
            _traverse(val[keys[i]], seen);
        }
      }

      var uid$1 = 0;
      /**
       * A watcher parses an expression, collects dependencies,
       * and fires callback when the expression value changes.
       * This is used for both the $watch() api and directives.
       * @internal
       */
      var Watcher = /** @class */ (function () {
        function Watcher(vm, expOrFn, cb, options, isRenderWatcher) {
          recordEffectScope(this,
              // if the active effect scope is manually created (not a component scope),
              // prioritize it
              activeEffectScope && !activeEffectScope._vm
                  ? activeEffectScope
                  : vm
                  ? vm._scope
                  : undefined);
          if ((this.vm = vm) && isRenderWatcher) {
            vm._watcher = this;
          }
          // options
          if (options) {
            this.deep = !!options.deep;
            this.user = !!options.user;
            this.lazy = !!options.lazy;
            this.sync = !!options.sync;
            this.before = options.before;
            if (true) {
              this.onTrack = options.onTrack;
              this.onTrigger = options.onTrigger;
            }
          }
          else {
            this.deep = this.user = this.lazy = this.sync = false;
          }
          this.cb = cb;
          this.id = ++uid$1; // uid for batching
          this.active = true;
          this.post = false;
          this.dirty = this.lazy; // for lazy watchers
          this.deps = [];
          this.newDeps = [];
          this.depIds = new _Set();
          this.newDepIds = new _Set();
          this.expression =  true ? expOrFn.toString() : 0;
          // parse expression for getter
          if (isFunction(expOrFn)) {
            this.getter = expOrFn;
          }
          else {
            this.getter = parsePath(expOrFn);
            if (!this.getter) {
              this.getter = noop;
              true &&
              warn$2("Failed watching path: \"".concat(expOrFn, "\" ") +
                  'Watcher only accepts simple dot-delimited paths. ' +
                  'For full control, use a function instead.', vm);
            }
          }
          this.value = this.lazy ? undefined : this.get();
        }
        /**
         * Evaluate the getter, and re-collect dependencies.
         */
        Watcher.prototype.get = function () {
          pushTarget(this);
          var value;
          var vm = this.vm;
          try {
            value = this.getter.call(vm, vm);
          }
          catch (e) {
            if (this.user) {
              handleError(e, vm, "getter for watcher \"".concat(this.expression, "\""));
            }
            else {
              throw e;
            }
          }
          finally {
            // "touch" every property so they are all tracked as
            // dependencies for deep watching
            if (this.deep) {
              traverse(value);
            }
            popTarget();
            this.cleanupDeps();
          }
          return value;
        };
        /**
         * Add a dependency to this directive.
         */
        Watcher.prototype.addDep = function (dep) {
          var id = dep.id;
          if (!this.newDepIds.has(id)) {
            this.newDepIds.add(id);
            this.newDeps.push(dep);
            if (!this.depIds.has(id)) {
              dep.addSub(this);
            }
          }
        };
        /**
         * Clean up for dependency collection.
         */
        Watcher.prototype.cleanupDeps = function () {
          var i = this.deps.length;
          while (i--) {
            var dep = this.deps[i];
            if (!this.newDepIds.has(dep.id)) {
              dep.removeSub(this);
            }
          }
          var tmp = this.depIds;
          this.depIds = this.newDepIds;
          this.newDepIds = tmp;
          this.newDepIds.clear();
          tmp = this.deps;
          this.deps = this.newDeps;
          this.newDeps = tmp;
          this.newDeps.length = 0;
        };
        /**
         * Subscriber interface.
         * Will be called when a dependency changes.
         */
        Watcher.prototype.update = function () {
          /* istanbul ignore else */
          if (this.lazy) {
            this.dirty = true;
          }
          else if (this.sync) {
            this.run();
          }
          else {
            queueWatcher(this);
          }
        };
        /**
         * Scheduler job interface.
         * Will be called by the scheduler.
         */
        Watcher.prototype.run = function () {
          if (this.active) {
            var value = this.get();
            if (value !== this.value ||
                // Deep watchers and watchers on Object/Arrays should fire even
                // when the value is the same, because the value may
                // have mutated.
                isObject(value) ||
                this.deep) {
              // set new value
              var oldValue = this.value;
              this.value = value;
              if (this.user) {
                var info = "callback for watcher \"".concat(this.expression, "\"");
                invokeWithErrorHandling(this.cb, this.vm, [value, oldValue], this.vm, info);
              }
              else {
                this.cb.call(this.vm, value, oldValue);
              }
            }
          }
        };
        /**
         * Evaluate the value of the watcher.
         * This only gets called for lazy watchers.
         */
        Watcher.prototype.evaluate = function () {
          this.value = this.get();
          this.dirty = false;
        };
        /**
         * Depend on all deps collected by this watcher.
         */
        Watcher.prototype.depend = function () {
          var i = this.deps.length;
          while (i--) {
            this.deps[i].depend();
          }
        };
        /**
         * Remove self from all dependencies' subscriber list.
         */
        Watcher.prototype.teardown = function () {
          if (this.vm && !this.vm._isBeingDestroyed) {
            remove$2(this.vm._scope.effects, this);
          }
          if (this.active) {
            var i = this.deps.length;
            while (i--) {
              this.deps[i].removeSub(this);
            }
            this.active = false;
            if (this.onStop) {
              this.onStop();
            }
          }
        };
        return Watcher;
      }());

      var sharedPropertyDefinition = {
        enumerable: true,
        configurable: true,
        get: noop,
        set: noop
      };
      function proxy(target, sourceKey, key) {
        sharedPropertyDefinition.get = function proxyGetter() {
          return this[sourceKey][key];
        };
        sharedPropertyDefinition.set = function proxySetter(val) {
          this[sourceKey][key] = val;
        };
        Object.defineProperty(target, key, sharedPropertyDefinition);
      }
      function initState(vm) {
        var opts = vm.$options;
        if (opts.props)
          initProps$1(vm, opts.props);
        // Composition API
        initSetup(vm);
        if (opts.methods)
          initMethods(vm, opts.methods);
        if (opts.data) {
          initData(vm);
        }
        else {
          var ob = observe((vm._data = {}));
          ob && ob.vmCount++;
        }
        if (opts.computed)
          initComputed$1(vm, opts.computed);
        if (opts.watch && opts.watch !== nativeWatch) {
          initWatch(vm, opts.watch);
        }
      }
      function initProps$1(vm, propsOptions) {
        var propsData = vm.$options.propsData || {};
        var props = (vm._props = shallowReactive({}));
        // cache prop keys so that future props updates can iterate using Array
        // instead of dynamic object key enumeration.
        var keys = (vm.$options._propKeys = []);
        var isRoot = !vm.$parent;
        // root instance props should be converted
        if (!isRoot) {
          toggleObserving(false);
        }
        var _loop_1 = function (key) {
          keys.push(key);
          var value = validateProp(key, propsOptions, propsData, vm);
          /* istanbul ignore else */
          if (true) {
            var hyphenatedKey = hyphenate(key);
            if (isReservedAttribute(hyphenatedKey) ||
                config.isReservedAttr(hyphenatedKey)) {
              warn$2("\"".concat(hyphenatedKey, "\" is a reserved attribute and cannot be used as component prop."), vm);
            }
            defineReactive(props, key, value, function () {
              if (!isRoot && !isUpdatingChildComponent) {
                warn$2("Avoid mutating a prop directly since the value will be " +
                    "overwritten whenever the parent component re-renders. " +
                    "Instead, use a data or computed property based on the prop's " +
                    "value. Prop being mutated: \"".concat(key, "\""), vm);
              }
            });
          }
          else {}
          // static props are already proxied on the component's prototype
          // during Vue.extend(). We only need to proxy props defined at
          // instantiation here.
          if (!(key in vm)) {
            proxy(vm, "_props", key);
          }
        };
        for (var key in propsOptions) {
          _loop_1(key);
        }
        toggleObserving(true);
      }
      function initData(vm) {
        var data = vm.$options.data;
        data = vm._data = isFunction(data) ? getData(data, vm) : data || {};
        if (!isPlainObject(data)) {
          data = {};
          true &&
          warn$2('data functions should return an object:\n' +
              'https://v2.vuejs.org/v2/guide/components.html#data-Must-Be-a-Function', vm);
        }
        // proxy data on instance
        var keys = Object.keys(data);
        var props = vm.$options.props;
        var methods = vm.$options.methods;
        var i = keys.length;
        while (i--) {
          var key = keys[i];
          if (true) {
            if (methods && hasOwn(methods, key)) {
              warn$2("Method \"".concat(key, "\" has already been defined as a data property."), vm);
            }
          }
          if (props && hasOwn(props, key)) {
            true &&
            warn$2("The data property \"".concat(key, "\" is already declared as a prop. ") +
                "Use prop default value instead.", vm);
          }
          else if (!isReserved(key)) {
            proxy(vm, "_data", key);
          }
        }
        // observe data
        var ob = observe(data);
        ob && ob.vmCount++;
      }
      function getData(data, vm) {
        // #7573 disable dep collection when invoking data getters
        pushTarget();
        try {
          return data.call(vm, vm);
        }
        catch (e) {
          handleError(e, vm, "data()");
          return {};
        }
        finally {
          popTarget();
        }
      }
      var computedWatcherOptions = { lazy: true };
      function initComputed$1(vm, computed) {
        // $flow-disable-line
        var watchers = (vm._computedWatchers = Object.create(null));
        // computed properties are just getters during SSR
        var isSSR = isServerRendering();
        for (var key in computed) {
          var userDef = computed[key];
          var getter = isFunction(userDef) ? userDef : userDef.get;
          if ( true && getter == null) {
            warn$2("Getter is missing for computed property \"".concat(key, "\"."), vm);
          }
          if (!isSSR) {
            // create internal watcher for the computed property.
            watchers[key] = new Watcher(vm, getter || noop, noop, computedWatcherOptions);
          }
          // component-defined computed properties are already defined on the
          // component prototype. We only need to define computed properties defined
          // at instantiation here.
          if (!(key in vm)) {
            defineComputed(vm, key, userDef);
          }
          else if (true) {
            if (key in vm.$data) {
              warn$2("The computed property \"".concat(key, "\" is already defined in data."), vm);
            }
            else if (vm.$options.props && key in vm.$options.props) {
              warn$2("The computed property \"".concat(key, "\" is already defined as a prop."), vm);
            }
            else if (vm.$options.methods && key in vm.$options.methods) {
              warn$2("The computed property \"".concat(key, "\" is already defined as a method."), vm);
            }
          }
        }
      }
      function defineComputed(target, key, userDef) {
        var shouldCache = !isServerRendering();
        if (isFunction(userDef)) {
          sharedPropertyDefinition.get = shouldCache
              ? createComputedGetter(key)
              : createGetterInvoker(userDef);
          sharedPropertyDefinition.set = noop;
        }
        else {
          sharedPropertyDefinition.get = userDef.get
              ? shouldCache && userDef.cache !== false
                  ? createComputedGetter(key)
                  : createGetterInvoker(userDef.get)
              : noop;
          sharedPropertyDefinition.set = userDef.set || noop;
        }
        if ( true && sharedPropertyDefinition.set === noop) {
          sharedPropertyDefinition.set = function () {
            warn$2("Computed property \"".concat(key, "\" was assigned to but it has no setter."), this);
          };
        }
        Object.defineProperty(target, key, sharedPropertyDefinition);
      }
      function createComputedGetter(key) {
        return function computedGetter() {
          var watcher = this._computedWatchers && this._computedWatchers[key];
          if (watcher) {
            if (watcher.dirty) {
              watcher.evaluate();
            }
            if (Dep.target) {
              if ( true && Dep.target.onTrack) {
                Dep.target.onTrack({
                  effect: Dep.target,
                  target: this,
                  type: "get" /* TrackOpTypes.GET */,
                  key: key
                });
              }
              watcher.depend();
            }
            return watcher.value;
          }
        };
      }
      function createGetterInvoker(fn) {
        return function computedGetter() {
          return fn.call(this, this);
        };
      }
      function initMethods(vm, methods) {
        var props = vm.$options.props;
        for (var key in methods) {
          if (true) {
            if (typeof methods[key] !== 'function') {
              warn$2("Method \"".concat(key, "\" has type \"").concat(typeof methods[key], "\" in the component definition. ") +
                  "Did you reference the function correctly?", vm);
            }
            if (props && hasOwn(props, key)) {
              warn$2("Method \"".concat(key, "\" has already been defined as a prop."), vm);
            }
            if (key in vm && isReserved(key)) {
              warn$2("Method \"".concat(key, "\" conflicts with an existing Vue instance method. ") +
                  "Avoid defining component methods that start with _ or $.");
            }
          }
          vm[key] = typeof methods[key] !== 'function' ? noop : bind$1(methods[key], vm);
        }
      }
      function initWatch(vm, watch) {
        for (var key in watch) {
          var handler = watch[key];
          if (isArray(handler)) {
            for (var i = 0; i < handler.length; i++) {
              createWatcher(vm, key, handler[i]);
            }
          }
          else {
            createWatcher(vm, key, handler);
          }
        }
      }
      function createWatcher(vm, expOrFn, handler, options) {
        if (isPlainObject(handler)) {
          options = handler;
          handler = handler.handler;
        }
        if (typeof handler === 'string') {
          handler = vm[handler];
        }
        return vm.$watch(expOrFn, handler, options);
      }
      function stateMixin(Vue) {
        // flow somehow has problems with directly declared definition object
        // when using Object.defineProperty, so we have to procedurally build up
        // the object here.
        var dataDef = {};
        dataDef.get = function () {
          return this._data;
        };
        var propsDef = {};
        propsDef.get = function () {
          return this._props;
        };
        if (true) {
          dataDef.set = function () {
            warn$2('Avoid replacing instance root $data. ' +
                'Use nested data properties instead.', this);
          };
          propsDef.set = function () {
            warn$2("$props is readonly.", this);
          };
        }
        Object.defineProperty(Vue.prototype, '$data', dataDef);
        Object.defineProperty(Vue.prototype, '$props', propsDef);
        Vue.prototype.$set = set;
        Vue.prototype.$delete = del;
        Vue.prototype.$watch = function (expOrFn, cb, options) {
          var vm = this;
          if (isPlainObject(cb)) {
            return createWatcher(vm, expOrFn, cb, options);
          }
          options = options || {};
          options.user = true;
          var watcher = new Watcher(vm, expOrFn, cb, options);
          if (options.immediate) {
            var info = "callback for immediate watcher \"".concat(watcher.expression, "\"");
            pushTarget();
            invokeWithErrorHandling(cb, vm, [watcher.value], vm, info);
            popTarget();
          }
          return function unwatchFn() {
            watcher.teardown();
          };
        };
      }

      function initProvide(vm) {
        var provideOption = vm.$options.provide;
        if (provideOption) {
          var provided = isFunction(provideOption)
              ? provideOption.call(vm)
              : provideOption;
          if (!isObject(provided)) {
            return;
          }
          var source = resolveProvided(vm);
          // IE9 doesn't support Object.getOwnPropertyDescriptors so we have to
          // iterate the keys ourselves.
          var keys = hasSymbol ? Reflect.ownKeys(provided) : Object.keys(provided);
          for (var i = 0; i < keys.length; i++) {
            var key = keys[i];
            Object.defineProperty(source, key, Object.getOwnPropertyDescriptor(provided, key));
          }
        }
      }
      function initInjections(vm) {
        var result = resolveInject(vm.$options.inject, vm);
        if (result) {
          toggleObserving(false);
          Object.keys(result).forEach(function (key) {
            /* istanbul ignore else */
            if (true) {
              defineReactive(vm, key, result[key], function () {
                warn$2("Avoid mutating an injected value directly since the changes will be " +
                    "overwritten whenever the provided component re-renders. " +
                    "injection being mutated: \"".concat(key, "\""), vm);
              });
            }
            else {}
          });
          toggleObserving(true);
        }
      }
      function resolveInject(inject, vm) {
        if (inject) {
          // inject is :any because flow is not smart enough to figure out cached
          var result = Object.create(null);
          var keys = hasSymbol ? Reflect.ownKeys(inject) : Object.keys(inject);
          for (var i = 0; i < keys.length; i++) {
            var key = keys[i];
            // #6574 in case the inject object is observed...
            if (key === '__ob__')
              continue;
            var provideKey = inject[key].from;
            if (provideKey in vm._provided) {
              result[key] = vm._provided[provideKey];
            }
            else if ('default' in inject[key]) {
              var provideDefault = inject[key].default;
              result[key] = isFunction(provideDefault)
                  ? provideDefault.call(vm)
                  : provideDefault;
            }
            else if (true) {
              warn$2("Injection \"".concat(key, "\" not found"), vm);
            }
          }
          return result;
        }
      }

      var uid = 0;
      function initMixin$1(Vue) {
        Vue.prototype._init = function (options) {
          var vm = this;
          // a uid
          vm._uid = uid++;
          var startTag, endTag;
          /* istanbul ignore if */
          if ( true && config.performance && mark) {
            startTag = "vue-perf-start:".concat(vm._uid);
            endTag = "vue-perf-end:".concat(vm._uid);
            mark(startTag);
          }
          // a flag to mark this as a Vue instance without having to do instanceof
          // check
          vm._isVue = true;
          // avoid instances from being observed
          vm.__v_skip = true;
          // effect scope
          vm._scope = new EffectScope(true /* detached */);
          vm._scope._vm = true;
          // merge options
          if (options && options._isComponent) {
            // optimize internal component instantiation
            // since dynamic options merging is pretty slow, and none of the
            // internal component options needs special treatment.
            initInternalComponent(vm, options);
          }
          else {
            vm.$options = mergeOptions(resolveConstructorOptions(vm.constructor), options || {}, vm);
          }
          /* istanbul ignore else */
          if (true) {
            initProxy(vm);
          }
          else {}
          // expose real self
          vm._self = vm;
          initLifecycle(vm);
          initEvents(vm);
          initRender(vm);
          callHook$1(vm, 'beforeCreate', undefined, false /* setContext */);
          initInjections(vm); // resolve injections before data/props
          initState(vm);
          initProvide(vm); // resolve provide after data/props
          callHook$1(vm, 'created');
          /* istanbul ignore if */
          if ( true && config.performance && mark) {
            vm._name = formatComponentName(vm, false);
            mark(endTag);
            measure("vue ".concat(vm._name, " init"), startTag, endTag);
          }
          if (vm.$options.el) {
            vm.$mount(vm.$options.el);
          }
        };
      }
      function initInternalComponent(vm, options) {
        var opts = (vm.$options = Object.create(vm.constructor.options));
        // doing this because it's faster than dynamic enumeration.
        var parentVnode = options._parentVnode;
        opts.parent = options.parent;
        opts._parentVnode = parentVnode;
        var vnodeComponentOptions = parentVnode.componentOptions;
        opts.propsData = vnodeComponentOptions.propsData;
        opts._parentListeners = vnodeComponentOptions.listeners;
        opts._renderChildren = vnodeComponentOptions.children;
        opts._componentTag = vnodeComponentOptions.tag;
        if (options.render) {
          opts.render = options.render;
          opts.staticRenderFns = options.staticRenderFns;
        }
      }
      function resolveConstructorOptions(Ctor) {
        var options = Ctor.options;
        if (Ctor.super) {
          var superOptions = resolveConstructorOptions(Ctor.super);
          var cachedSuperOptions = Ctor.superOptions;
          if (superOptions !== cachedSuperOptions) {
            // super option changed,
            // need to resolve new options.
            Ctor.superOptions = superOptions;
            // check if there are any late-modified/attached options (#4976)
            var modifiedOptions = resolveModifiedOptions(Ctor);
            // update base extend options
            if (modifiedOptions) {
              extend(Ctor.extendOptions, modifiedOptions);
            }
            options = Ctor.options = mergeOptions(superOptions, Ctor.extendOptions);
            if (options.name) {
              options.components[options.name] = Ctor;
            }
          }
        }
        return options;
      }
      function resolveModifiedOptions(Ctor) {
        var modified;
        var latest = Ctor.options;
        var sealed = Ctor.sealedOptions;
        for (var key in latest) {
          if (latest[key] !== sealed[key]) {
            if (!modified)
              modified = {};
            modified[key] = latest[key];
          }
        }
        return modified;
      }

      function FunctionalRenderContext(data, props, children, parent, Ctor) {
        var _this = this;
        var options = Ctor.options;
        // ensure the createElement function in functional components
        // gets a unique context - this is necessary for correct named slot check
        var contextVm;
        if (hasOwn(parent, '_uid')) {
          contextVm = Object.create(parent);
          contextVm._original = parent;
        }
        else {
          // the context vm passed in is a functional context as well.
          // in this case we want to make sure we are able to get a hold to the
          // real context instance.
          contextVm = parent;
          // @ts-ignore
          parent = parent._original;
        }
        var isCompiled = isTrue(options._compiled);
        var needNormalization = !isCompiled;
        this.data = data;
        this.props = props;
        this.children = children;
        this.parent = parent;
        this.listeners = data.on || emptyObject;
        this.injections = resolveInject(options.inject, parent);
        this.slots = function () {
          if (!_this.$slots) {
            normalizeScopedSlots(parent, data.scopedSlots, (_this.$slots = resolveSlots(children, parent)));
          }
          return _this.$slots;
        };
        Object.defineProperty(this, 'scopedSlots', {
          enumerable: true,
          get: function () {
            return normalizeScopedSlots(parent, data.scopedSlots, this.slots());
          }
        });
        // support for compiled functional template
        if (isCompiled) {
          // exposing $options for renderStatic()
          this.$options = options;
          // pre-resolve slots for renderSlot()
          this.$slots = this.slots();
          this.$scopedSlots = normalizeScopedSlots(parent, data.scopedSlots, this.$slots);
        }
        if (options._scopeId) {
          this._c = function (a, b, c, d) {
            var vnode = createElement$1(contextVm, a, b, c, d, needNormalization);
            if (vnode && !isArray(vnode)) {
              vnode.fnScopeId = options._scopeId;
              vnode.fnContext = parent;
            }
            return vnode;
          };
        }
        else {
          this._c = function (a, b, c, d) {
            return createElement$1(contextVm, a, b, c, d, needNormalization);
          };
        }
      }
      installRenderHelpers(FunctionalRenderContext.prototype);
      function createFunctionalComponent(Ctor, propsData, data, contextVm, children) {
        var options = Ctor.options;
        var props = {};
        var propOptions = options.props;
        if (isDef(propOptions)) {
          for (var key in propOptions) {
            props[key] = validateProp(key, propOptions, propsData || emptyObject);
          }
        }
        else {
          if (isDef(data.attrs))
            mergeProps(props, data.attrs);
          if (isDef(data.props))
            mergeProps(props, data.props);
        }
        var renderContext = new FunctionalRenderContext(data, props, children, contextVm, Ctor);
        var vnode = options.render.call(null, renderContext._c, renderContext);
        if (vnode instanceof VNode) {
          return cloneAndMarkFunctionalResult(vnode, data, renderContext.parent, options, renderContext);
        }
        else if (isArray(vnode)) {
          var vnodes = normalizeChildren(vnode) || [];
          var res = new Array(vnodes.length);
          for (var i = 0; i < vnodes.length; i++) {
            res[i] = cloneAndMarkFunctionalResult(vnodes[i], data, renderContext.parent, options, renderContext);
          }
          return res;
        }
      }
      function cloneAndMarkFunctionalResult(vnode, data, contextVm, options, renderContext) {
        // #7817 clone node before setting fnContext, otherwise if the node is reused
        // (e.g. it was from a cached normal slot) the fnContext causes named slots
        // that should not be matched to match.
        var clone = cloneVNode(vnode);
        clone.fnContext = contextVm;
        clone.fnOptions = options;
        if (true) {
          (clone.devtoolsMeta = clone.devtoolsMeta || {}).renderContext =
              renderContext;
        }
        if (data.slot) {
          (clone.data || (clone.data = {})).slot = data.slot;
        }
        return clone;
      }
      function mergeProps(to, from) {
        for (var key in from) {
          to[camelize(key)] = from[key];
        }
      }

      function getComponentName(options) {
        return options.name || options.__name || options._componentTag;
      }
// inline hooks to be invoked on component VNodes during patch
      var componentVNodeHooks = {
        init: function (vnode, hydrating) {
          if (vnode.componentInstance &&
              !vnode.componentInstance._isDestroyed &&
              vnode.data.keepAlive) {
            // kept-alive components, treat as a patch
            var mountedNode = vnode; // work around flow
            componentVNodeHooks.prepatch(mountedNode, mountedNode);
          }
          else {
            var child = (vnode.componentInstance = createComponentInstanceForVnode(vnode, activeInstance));
            child.$mount(hydrating ? vnode.elm : undefined, hydrating);
          }
        },
        prepatch: function (oldVnode, vnode) {
          var options = vnode.componentOptions;
          var child = (vnode.componentInstance = oldVnode.componentInstance);
          updateChildComponent(child, options.propsData, // updated props
              options.listeners, // updated listeners
              vnode, // new parent vnode
              options.children // new children
          );
        },
        insert: function (vnode) {
          var context = vnode.context, componentInstance = vnode.componentInstance;
          if (!componentInstance._isMounted) {
            componentInstance._isMounted = true;
            callHook$1(componentInstance, 'mounted');
          }
          if (vnode.data.keepAlive) {
            if (context._isMounted) {
              // vue-router#1212
              // During updates, a kept-alive component's child components may
              // change, so directly walking the tree here may call activated hooks
              // on incorrect children. Instead we push them into a queue which will
              // be processed after the whole patch process ended.
              queueActivatedComponent(componentInstance);
            }
            else {
              activateChildComponent(componentInstance, true /* direct */);
            }
          }
        },
        destroy: function (vnode) {
          var componentInstance = vnode.componentInstance;
          if (!componentInstance._isDestroyed) {
            if (!vnode.data.keepAlive) {
              componentInstance.$destroy();
            }
            else {
              deactivateChildComponent(componentInstance, true /* direct */);
            }
          }
        }
      };
      var hooksToMerge = Object.keys(componentVNodeHooks);
      function createComponent(Ctor, data, context, children, tag) {
        if (isUndef(Ctor)) {
          return;
        }
        var baseCtor = context.$options._base;
        // plain options object: turn it into a constructor
        if (isObject(Ctor)) {
          Ctor = baseCtor.extend(Ctor);
        }
        // if at this stage it's not a constructor or an async component factory,
        // reject.
        if (typeof Ctor !== 'function') {
          if (true) {
            warn$2("Invalid Component definition: ".concat(String(Ctor)), context);
          }
          return;
        }
        // async component
        var asyncFactory;
        // @ts-expect-error
        if (isUndef(Ctor.cid)) {
          asyncFactory = Ctor;
          Ctor = resolveAsyncComponent(asyncFactory, baseCtor);
          if (Ctor === undefined) {
            // return a placeholder node for async component, which is rendered
            // as a comment node but preserves all the raw information for the node.
            // the information will be used for async server-rendering and hydration.
            return createAsyncPlaceholder(asyncFactory, data, context, children, tag);
          }
        }
        data = data || {};
        // resolve constructor options in case global mixins are applied after
        // component constructor creation
        resolveConstructorOptions(Ctor);
        // transform component v-model data into props & events
        if (isDef(data.model)) {
          // @ts-expect-error
          transformModel(Ctor.options, data);
        }
        // extract props
        // @ts-expect-error
        var propsData = extractPropsFromVNodeData(data, Ctor, tag);
        // functional component
        // @ts-expect-error
        if (isTrue(Ctor.options.functional)) {
          return createFunctionalComponent(Ctor, propsData, data, context, children);
        }
        // extract listeners, since these needs to be treated as
        // child component listeners instead of DOM listeners
        var listeners = data.on;
        // replace with listeners with .native modifier
        // so it gets processed during parent component patch.
        data.on = data.nativeOn;
        // @ts-expect-error
        if (isTrue(Ctor.options.abstract)) {
          // abstract components do not keep anything
          // other than props & listeners & slot
          // work around flow
          var slot = data.slot;
          data = {};
          if (slot) {
            data.slot = slot;
          }
        }
        // install component management hooks onto the placeholder node
        installComponentHooks(data);
        // return a placeholder vnode
        // @ts-expect-error
        var name = getComponentName(Ctor.options) || tag;
        var vnode = new VNode(
            // @ts-expect-error
            "vue-component-".concat(Ctor.cid).concat(name ? "-".concat(name) : ''), data, undefined, undefined, undefined, context,
            // @ts-expect-error
            { Ctor: Ctor, propsData: propsData, listeners: listeners, tag: tag, children: children }, asyncFactory);
        return vnode;
      }
      function createComponentInstanceForVnode(
// we know it's MountedComponentVNode but flow doesn't
vnode,
// activeInstance in lifecycle state
parent) {
        var options = {
          _isComponent: true,
          _parentVnode: vnode,
          parent: parent
        };
        // check inline-template render functions
        var inlineTemplate = vnode.data.inlineTemplate;
        if (isDef(inlineTemplate)) {
          options.render = inlineTemplate.render;
          options.staticRenderFns = inlineTemplate.staticRenderFns;
        }
        return new vnode.componentOptions.Ctor(options);
      }
      function installComponentHooks(data) {
        var hooks = data.hook || (data.hook = {});
        for (var i = 0; i < hooksToMerge.length; i++) {
          var key = hooksToMerge[i];
          var existing = hooks[key];
          var toMerge = componentVNodeHooks[key];
          // @ts-expect-error
          if (existing !== toMerge && !(existing && existing._merged)) {
            hooks[key] = existing ? mergeHook(toMerge, existing) : toMerge;
          }
        }
      }
      function mergeHook(f1, f2) {
        var merged = function (a, b) {
          // flow complains about extra args which is why we use any
          f1(a, b);
          f2(a, b);
        };
        merged._merged = true;
        return merged;
      }
// transform component v-model info (value and callback) into
// prop and event handler respectively.
      function transformModel(options, data) {
        var prop = (options.model && options.model.prop) || 'value';
        var event = (options.model && options.model.event) || 'input';
        (data.attrs || (data.attrs = {}))[prop] = data.model.value;
        var on = data.on || (data.on = {});
        var existing = on[event];
        var callback = data.model.callback;
        if (isDef(existing)) {
          if (isArray(existing)
              ? existing.indexOf(callback) === -1
              : existing !== callback) {
            on[event] = [callback].concat(existing);
          }
        }
        else {
          on[event] = callback;
        }
      }

      var warn$2 = noop;
      var tip = noop;
      var generateComponentTrace; // work around flow check
      var formatComponentName;
      if (true) {
        var hasConsole_1 = typeof console !== 'undefined';
        var classifyRE_1 = /(?:^|[-_])(\w)/g;
        var classify_1 = function (str) {
          return str.replace(classifyRE_1, function (c) { return c.toUpperCase(); }).replace(/[-_]/g, '');
        };
        warn$2 = function (msg, vm) {
          if (vm === void 0) { vm = currentInstance; }
          var trace = vm ? generateComponentTrace(vm) : '';
          if (config.warnHandler) {
            config.warnHandler.call(null, msg, vm, trace);
          }
          else if (hasConsole_1 && !config.silent) {
            console.error("[Vue warn]: ".concat(msg).concat(trace));
          }
        };
        tip = function (msg, vm) {
          if (hasConsole_1 && !config.silent) {
            console.warn("[Vue tip]: ".concat(msg) + (vm ? generateComponentTrace(vm) : ''));
          }
        };
        formatComponentName = function (vm, includeFile) {
          if (vm.$root === vm) {
            return '<Root>';
          }
          var options = isFunction(vm) && vm.cid != null
              ? vm.options
              : vm._isVue
                  ? vm.$options || vm.constructor.options
                  : vm;
          var name = getComponentName(options);
          var file = options.__file;
          if (!name && file) {
            var match = file.match(/([^/\\]+)\.vue$/);
            name = match && match[1];
          }
          return ((name ? "<".concat(classify_1(name), ">") : "<Anonymous>") +
              (file && includeFile !== false ? " at ".concat(file) : ''));
        };
        var repeat_1 = function (str, n) {
          var res = '';
          while (n) {
            if (n % 2 === 1)
              res += str;
            if (n > 1)
              str += str;
            n >>= 1;
          }
          return res;
        };
        generateComponentTrace = function (vm) {
          if (vm._isVue && vm.$parent) {
            var tree = [];
            var currentRecursiveSequence = 0;
            while (vm) {
              if (tree.length > 0) {
                var last = tree[tree.length - 1];
                if (last.constructor === vm.constructor) {
                  currentRecursiveSequence++;
                  vm = vm.$parent;
                  continue;
                }
                else if (currentRecursiveSequence > 0) {
                  tree[tree.length - 1] = [last, currentRecursiveSequence];
                  currentRecursiveSequence = 0;
                }
              }
              tree.push(vm);
              vm = vm.$parent;
            }
            return ('\n\nfound in\n\n' +
                tree
                    .map(function (vm, i) {
                      return "".concat(i === 0 ? '---> ' : repeat_1(' ', 5 + i * 2)).concat(isArray(vm)
                          ? "".concat(formatComponentName(vm[0]), "... (").concat(vm[1], " recursive calls)")
                          : formatComponentName(vm));
                    })
                    .join('\n'));
          }
          else {
            return "\n\n(found in ".concat(formatComponentName(vm), ")");
          }
        };
      }

      /**
       * Option overwriting strategies are functions that handle
       * how to merge a parent option value and a child option
       * value into the final value.
       */
      var strats = config.optionMergeStrategies;
      /**
       * Options with restrictions
       */
      if (true) {
        strats.el = strats.propsData = function (parent, child, vm, key) {
          if (!vm) {
            warn$2("option \"".concat(key, "\" can only be used during instance ") +
                'creation with the `new` keyword.');
          }
          return defaultStrat(parent, child);
        };
      }
      /**
       * Helper that recursively merges two data objects together.
       */
      function mergeData(to, from, recursive) {
        if (recursive === void 0) { recursive = true; }
        if (!from)
          return to;
        var key, toVal, fromVal;
        var keys = hasSymbol
            ? Reflect.ownKeys(from)
            : Object.keys(from);
        for (var i = 0; i < keys.length; i++) {
          key = keys[i];
          // in case the object is already observed...
          if (key === '__ob__')
            continue;
          toVal = to[key];
          fromVal = from[key];
          if (!recursive || !hasOwn(to, key)) {
            set(to, key, fromVal);
          }
          else if (toVal !== fromVal &&
              isPlainObject(toVal) &&
              isPlainObject(fromVal)) {
            mergeData(toVal, fromVal);
          }
        }
        return to;
      }
      /**
       * Data
       */
      function mergeDataOrFn(parentVal, childVal, vm) {
        if (!vm) {
          // in a Vue.extend merge, both should be functions
          if (!childVal) {
            return parentVal;
          }
          if (!parentVal) {
            return childVal;
          }
          // when parentVal & childVal are both present,
          // we need to return a function that returns the
          // merged result of both functions... no need to
          // check if parentVal is a function here because
          // it has to be a function to pass previous merges.
          return function mergedDataFn() {
            return mergeData(isFunction(childVal) ? childVal.call(this, this) : childVal, isFunction(parentVal) ? parentVal.call(this, this) : parentVal);
          };
        }
        else {
          return function mergedInstanceDataFn() {
            // instance merge
            var instanceData = isFunction(childVal)
                ? childVal.call(vm, vm)
                : childVal;
            var defaultData = isFunction(parentVal)
                ? parentVal.call(vm, vm)
                : parentVal;
            if (instanceData) {
              return mergeData(instanceData, defaultData);
            }
            else {
              return defaultData;
            }
          };
        }
      }
      strats.data = function (parentVal, childVal, vm) {
        if (!vm) {
          if (childVal && typeof childVal !== 'function') {
            true &&
            warn$2('The "data" option should be a function ' +
                'that returns a per-instance value in component ' +
                'definitions.', vm);
            return parentVal;
          }
          return mergeDataOrFn(parentVal, childVal);
        }
        return mergeDataOrFn(parentVal, childVal, vm);
      };
      /**
       * Hooks and props are merged as arrays.
       */
      function mergeLifecycleHook(parentVal, childVal) {
        var res = childVal
            ? parentVal
                ? parentVal.concat(childVal)
                : isArray(childVal)
                    ? childVal
                    : [childVal]
            : parentVal;
        return res ? dedupeHooks(res) : res;
      }
      function dedupeHooks(hooks) {
        var res = [];
        for (var i = 0; i < hooks.length; i++) {
          if (res.indexOf(hooks[i]) === -1) {
            res.push(hooks[i]);
          }
        }
        return res;
      }
      LIFECYCLE_HOOKS.forEach(function (hook) {
        strats[hook] = mergeLifecycleHook;
      });
      /**
       * Assets
       *
       * When a vm is present (instance creation), we need to do
       * a three-way merge between constructor options, instance
       * options and parent options.
       */
      function mergeAssets(parentVal, childVal, vm, key) {
        var res = Object.create(parentVal || null);
        if (childVal) {
          true && assertObjectType(key, childVal, vm);
          return extend(res, childVal);
        }
        else {
          return res;
        }
      }
      ASSET_TYPES.forEach(function (type) {
        strats[type + 's'] = mergeAssets;
      });
      /**
       * Watchers.
       *
       * Watchers hashes should not overwrite one
       * another, so we merge them as arrays.
       */
      strats.watch = function (parentVal, childVal, vm, key) {
        // work around Firefox's Object.prototype.watch...
        //@ts-expect-error work around
        if (parentVal === nativeWatch)
          parentVal = undefined;
        //@ts-expect-error work around
        if (childVal === nativeWatch)
          childVal = undefined;
        /* istanbul ignore if */
        if (!childVal)
          return Object.create(parentVal || null);
        if (true) {
          assertObjectType(key, childVal, vm);
        }
        if (!parentVal)
          return childVal;
        var ret = {};
        extend(ret, parentVal);
        for (var key_1 in childVal) {
          var parent_1 = ret[key_1];
          var child = childVal[key_1];
          if (parent_1 && !isArray(parent_1)) {
            parent_1 = [parent_1];
          }
          ret[key_1] = parent_1 ? parent_1.concat(child) : isArray(child) ? child : [child];
        }
        return ret;
      };
      /**
       * Other object hashes.
       */
      strats.props =
          strats.methods =
              strats.inject =
                  strats.computed =
                      function (parentVal, childVal, vm, key) {
                        if (childVal && "development" !== 'production') {
                          assertObjectType(key, childVal, vm);
                        }
                        if (!parentVal)
                          return childVal;
                        var ret = Object.create(null);
                        extend(ret, parentVal);
                        if (childVal)
                          extend(ret, childVal);
                        return ret;
                      };
      strats.provide = function (parentVal, childVal) {
        if (!parentVal)
          return childVal;
        return function () {
          var ret = Object.create(null);
          mergeData(ret, isFunction(parentVal) ? parentVal.call(this) : parentVal);
          if (childVal) {
            mergeData(ret, isFunction(childVal) ? childVal.call(this) : childVal, false // non-recursive
            );
          }
          return ret;
        };
      };
      /**
       * Default strategy.
       */
      var defaultStrat = function (parentVal, childVal) {
        return childVal === undefined ? parentVal : childVal;
      };
      /**
       * Validate component names
       */
      function checkComponents(options) {
        for (var key in options.components) {
          validateComponentName(key);
        }
      }
      function validateComponentName(name) {
        if (!new RegExp("^[a-zA-Z][\\-\\.0-9_".concat(unicodeRegExp.source, "]*$")).test(name)) {
          warn$2('Invalid component name: "' +
              name +
              '". Component names ' +
              'should conform to valid custom element name in html5 specification.');
        }
        if (isBuiltInTag(name) || config.isReservedTag(name)) {
          warn$2('Do not use built-in or reserved HTML elements as component ' +
              'id: ' +
              name);
        }
      }
      /**
       * Ensure all props option syntax are normalized into the
       * Object-based format.
       */
      function normalizeProps(options, vm) {
        var props = options.props;
        if (!props)
          return;
        var res = {};
        var i, val, name;
        if (isArray(props)) {
          i = props.length;
          while (i--) {
            val = props[i];
            if (typeof val === 'string') {
              name = camelize(val);
              res[name] = { type: null };
            }
            else if (true) {
              warn$2('props must be strings when using array syntax.');
            }
          }
        }
        else if (isPlainObject(props)) {
          for (var key in props) {
            val = props[key];
            name = camelize(key);
            res[name] = isPlainObject(val) ? val : { type: val };
          }
        }
        else if (true) {
          warn$2("Invalid value for option \"props\": expected an Array or an Object, " +
              "but got ".concat(toRawType(props), "."), vm);
        }
        options.props = res;
      }
      /**
       * Normalize all injections into Object-based format
       */
      function normalizeInject(options, vm) {
        var inject = options.inject;
        if (!inject)
          return;
        var normalized = (options.inject = {});
        if (isArray(inject)) {
          for (var i = 0; i < inject.length; i++) {
            normalized[inject[i]] = { from: inject[i] };
          }
        }
        else if (isPlainObject(inject)) {
          for (var key in inject) {
            var val = inject[key];
            normalized[key] = isPlainObject(val)
                ? extend({ from: key }, val)
                : { from: val };
          }
        }
        else if (true) {
          warn$2("Invalid value for option \"inject\": expected an Array or an Object, " +
              "but got ".concat(toRawType(inject), "."), vm);
        }
      }
      /**
       * Normalize raw function directives into object format.
       */
      function normalizeDirectives$1(options) {
        var dirs = options.directives;
        if (dirs) {
          for (var key in dirs) {
            var def = dirs[key];
            if (isFunction(def)) {
              dirs[key] = { bind: def, update: def };
            }
          }
        }
      }
      function assertObjectType(name, value, vm) {
        if (!isPlainObject(value)) {
          warn$2("Invalid value for option \"".concat(name, "\": expected an Object, ") +
              "but got ".concat(toRawType(value), "."), vm);
        }
      }
      /**
       * Merge two option objects into a new one.
       * Core utility used in both instantiation and inheritance.
       */
      function mergeOptions(parent, child, vm) {
        if (true) {
          checkComponents(child);
        }
        if (isFunction(child)) {
          // @ts-expect-error
          child = child.options;
        }
        normalizeProps(child, vm);
        normalizeInject(child, vm);
        normalizeDirectives$1(child);
        // Apply extends and mixins on the child options,
        // but only if it is a raw options object that isn't
        // the result of another mergeOptions call.
        // Only merged options has the _base property.
        if (!child._base) {
          if (child.extends) {
            parent = mergeOptions(parent, child.extends, vm);
          }
          if (child.mixins) {
            for (var i = 0, l = child.mixins.length; i < l; i++) {
              parent = mergeOptions(parent, child.mixins[i], vm);
            }
          }
        }
        var options = {};
        var key;
        for (key in parent) {
          mergeField(key);
        }
        for (key in child) {
          if (!hasOwn(parent, key)) {
            mergeField(key);
          }
        }
        function mergeField(key) {
          var strat = strats[key] || defaultStrat;
          options[key] = strat(parent[key], child[key], vm, key);
        }
        return options;
      }
      /**
       * Resolve an asset.
       * This function is used because child instances need access
       * to assets defined in its ancestor chain.
       */
      function resolveAsset(options, type, id, warnMissing) {
        /* istanbul ignore if */
        if (typeof id !== 'string') {
          return;
        }
        var assets = options[type];
        // check local registration variations first
        if (hasOwn(assets, id))
          return assets[id];
        var camelizedId = camelize(id);
        if (hasOwn(assets, camelizedId))
          return assets[camelizedId];
        var PascalCaseId = capitalize(camelizedId);
        if (hasOwn(assets, PascalCaseId))
          return assets[PascalCaseId];
        // fallback to prototype chain
        var res = assets[id] || assets[camelizedId] || assets[PascalCaseId];
        if ( true && warnMissing && !res) {
          warn$2('Failed to resolve ' + type.slice(0, -1) + ': ' + id);
        }
        return res;
      }

      function validateProp(key, propOptions, propsData, vm) {
        var prop = propOptions[key];
        var absent = !hasOwn(propsData, key);
        var value = propsData[key];
        // boolean casting
        var booleanIndex = getTypeIndex(Boolean, prop.type);
        if (booleanIndex > -1) {
          if (absent && !hasOwn(prop, 'default')) {
            value = false;
          }
          else if (value === '' || value === hyphenate(key)) {
            // only cast empty string / same name to boolean if
            // boolean has higher priority
            var stringIndex = getTypeIndex(String, prop.type);
            if (stringIndex < 0 || booleanIndex < stringIndex) {
              value = true;
            }
          }
        }
        // check default value
        if (value === undefined) {
          value = getPropDefaultValue(vm, prop, key);
          // since the default value is a fresh copy,
          // make sure to observe it.
          var prevShouldObserve = shouldObserve;
          toggleObserving(true);
          observe(value);
          toggleObserving(prevShouldObserve);
        }
        if (true) {
          assertProp(prop, key, value, vm, absent);
        }
        return value;
      }
      /**
       * Get the default value of a prop.
       */
      function getPropDefaultValue(vm, prop, key) {
        // no default, return undefined
        if (!hasOwn(prop, 'default')) {
          return undefined;
        }
        var def = prop.default;
        // warn against non-factory defaults for Object & Array
        if ( true && isObject(def)) {
          warn$2('Invalid default value for prop "' +
              key +
              '": ' +
              'Props with type Object/Array must use a factory function ' +
              'to return the default value.', vm);
        }
        // the raw prop value was also undefined from previous render,
        // return previous default value to avoid unnecessary watcher trigger
        if (vm &&
            vm.$options.propsData &&
            vm.$options.propsData[key] === undefined &&
            vm._props[key] !== undefined) {
          return vm._props[key];
        }
        // call factory function for non-Function types
        // a value is Function if its prototype is function even across different execution context
        return isFunction(def) && getType(prop.type) !== 'Function'
            ? def.call(vm)
            : def;
      }
      /**
       * Assert whether a prop is valid.
       */
      function assertProp(prop, name, value, vm, absent) {
        if (prop.required && absent) {
          warn$2('Missing required prop: "' + name + '"', vm);
          return;
        }
        if (value == null && !prop.required) {
          return;
        }
        var type = prop.type;
        var valid = !type || type === true;
        var expectedTypes = [];
        if (type) {
          if (!isArray(type)) {
            type = [type];
          }
          for (var i = 0; i < type.length && !valid; i++) {
            var assertedType = assertType(value, type[i], vm);
            expectedTypes.push(assertedType.expectedType || '');
            valid = assertedType.valid;
          }
        }
        var haveExpectedTypes = expectedTypes.some(function (t) { return t; });
        if (!valid && haveExpectedTypes) {
          warn$2(getInvalidTypeMessage(name, value, expectedTypes), vm);
          return;
        }
        var validator = prop.validator;
        if (validator) {
          if (!validator(value)) {
            warn$2('Invalid prop: custom validator check failed for prop "' + name + '".', vm);
          }
        }
      }
      var simpleCheckRE = /^(String|Number|Boolean|Function|Symbol|BigInt)$/;
      function assertType(value, type, vm) {
        var valid;
        var expectedType = getType(type);
        if (simpleCheckRE.test(expectedType)) {
          var t = typeof value;
          valid = t === expectedType.toLowerCase();
          // for primitive wrapper objects
          if (!valid && t === 'object') {
            valid = value instanceof type;
          }
        }
        else if (expectedType === 'Object') {
          valid = isPlainObject(value);
        }
        else if (expectedType === 'Array') {
          valid = isArray(value);
        }
        else {
          try {
            valid = value instanceof type;
          }
          catch (e) {
            warn$2('Invalid prop type: "' + String(type) + '" is not a constructor', vm);
            valid = false;
          }
        }
        return {
          valid: valid,
          expectedType: expectedType
        };
      }
      var functionTypeCheckRE = /^\s*function (\w+)/;
      /**
       * Use function string name to check built-in types,
       * because a simple equality check will fail when running
       * across different vms / iframes.
       */
      function getType(fn) {
        var match = fn && fn.toString().match(functionTypeCheckRE);
        return match ? match[1] : '';
      }
      function isSameType(a, b) {
        return getType(a) === getType(b);
      }
      function getTypeIndex(type, expectedTypes) {
        if (!isArray(expectedTypes)) {
          return isSameType(expectedTypes, type) ? 0 : -1;
        }
        for (var i = 0, len = expectedTypes.length; i < len; i++) {
          if (isSameType(expectedTypes[i], type)) {
            return i;
          }
        }
        return -1;
      }
      function getInvalidTypeMessage(name, value, expectedTypes) {
        var message = "Invalid prop: type check failed for prop \"".concat(name, "\".") +
            " Expected ".concat(expectedTypes.map(capitalize).join(', '));
        var expectedType = expectedTypes[0];
        var receivedType = toRawType(value);
        // check if we need to specify expected value
        if (expectedTypes.length === 1 &&
            isExplicable(expectedType) &&
            isExplicable(typeof value) &&
            !isBoolean(expectedType, receivedType)) {
          message += " with value ".concat(styleValue(value, expectedType));
        }
        message += ", got ".concat(receivedType, " ");
        // check if we need to specify received value
        if (isExplicable(receivedType)) {
          message += "with value ".concat(styleValue(value, receivedType), ".");
        }
        return message;
      }
      function styleValue(value, type) {
        if (type === 'String') {
          return "\"".concat(value, "\"");
        }
        else if (type === 'Number') {
          return "".concat(Number(value));
        }
        else {
          return "".concat(value);
        }
      }
      var EXPLICABLE_TYPES = ['string', 'number', 'boolean'];
      function isExplicable(value) {
        return EXPLICABLE_TYPES.some(function (elem) { return value.toLowerCase() === elem; });
      }
      function isBoolean() {
        var args = [];
        for (var _i = 0; _i < arguments.length; _i++) {
          args[_i] = arguments[_i];
        }
        return args.some(function (elem) { return elem.toLowerCase() === 'boolean'; });
      }

      function Vue(options) {
        if ( true && !(this instanceof Vue)) {
          warn$2('Vue is a constructor and should be called with the `new` keyword');
        }
        this._init(options);
      }
//@ts-expect-error Vue has function type
      initMixin$1(Vue);
//@ts-expect-error Vue has function type
      stateMixin(Vue);
//@ts-expect-error Vue has function type
      eventsMixin(Vue);
//@ts-expect-error Vue has function type
      lifecycleMixin(Vue);
//@ts-expect-error Vue has function type
      renderMixin(Vue);

      function initUse(Vue) {
        Vue.use = function (plugin) {
          var installedPlugins = this._installedPlugins || (this._installedPlugins = []);
          if (installedPlugins.indexOf(plugin) > -1) {
            return this;
          }
          // additional parameters
          var args = toArray(arguments, 1);
          args.unshift(this);
          if (isFunction(plugin.install)) {
            plugin.install.apply(plugin, args);
          }
          else if (isFunction(plugin)) {
            plugin.apply(null, args);
          }
          installedPlugins.push(plugin);
          return this;
        };
      }

      function initMixin(Vue) {
        Vue.mixin = function (mixin) {
          this.options = mergeOptions(this.options, mixin);
          return this;
        };
      }

      function initExtend(Vue) {
        /**
         * Each instance constructor, including Vue, has a unique
         * cid. This enables us to create wrapped "child
         * constructors" for prototypal inheritance and cache them.
         */
        Vue.cid = 0;
        var cid = 1;
        /**
         * Class inheritance
         */
        Vue.extend = function (extendOptions) {
          extendOptions = extendOptions || {};
          var Super = this;
          var SuperId = Super.cid;
          var cachedCtors = extendOptions._Ctor || (extendOptions._Ctor = {});
          if (cachedCtors[SuperId]) {
            return cachedCtors[SuperId];
          }
          var name = getComponentName(extendOptions) || getComponentName(Super.options);
          if ( true && name) {
            validateComponentName(name);
          }
          var Sub = function VueComponent(options) {
            this._init(options);
          };
          Sub.prototype = Object.create(Super.prototype);
          Sub.prototype.constructor = Sub;
          Sub.cid = cid++;
          Sub.options = mergeOptions(Super.options, extendOptions);
          Sub['super'] = Super;
          // For props and computed properties, we define the proxy getters on
          // the Vue instances at extension time, on the extended prototype. This
          // avoids Object.defineProperty calls for each instance created.
          if (Sub.options.props) {
            initProps(Sub);
          }
          if (Sub.options.computed) {
            initComputed(Sub);
          }
          // allow further extension/mixin/plugin usage
          Sub.extend = Super.extend;
          Sub.mixin = Super.mixin;
          Sub.use = Super.use;
          // create asset registers, so extended classes
          // can have their private assets too.
          ASSET_TYPES.forEach(function (type) {
            Sub[type] = Super[type];
          });
          // enable recursive self-lookup
          if (name) {
            Sub.options.components[name] = Sub;
          }
          // keep a reference to the super options at extension time.
          // later at instantiation we can check if Super's options have
          // been updated.
          Sub.superOptions = Super.options;
          Sub.extendOptions = extendOptions;
          Sub.sealedOptions = extend({}, Sub.options);
          // cache constructor
          cachedCtors[SuperId] = Sub;
          return Sub;
        };
      }
      function initProps(Comp) {
        var props = Comp.options.props;
        for (var key in props) {
          proxy(Comp.prototype, "_props", key);
        }
      }
      function initComputed(Comp) {
        var computed = Comp.options.computed;
        for (var key in computed) {
          defineComputed(Comp.prototype, key, computed[key]);
        }
      }

      function initAssetRegisters(Vue) {
        /**
         * Create asset registration methods.
         */
        ASSET_TYPES.forEach(function (type) {
          // @ts-expect-error function is not exact same type
          Vue[type] = function (id, definition) {
            if (!definition) {
              return this.options[type + 's'][id];
            }
            else {
              /* istanbul ignore if */
              if ( true && type === 'component') {
                validateComponentName(id);
              }
              if (type === 'component' && isPlainObject(definition)) {
                // @ts-expect-error
                definition.name = definition.name || id;
                definition = this.options._base.extend(definition);
              }
              if (type === 'directive' && isFunction(definition)) {
                definition = { bind: definition, update: definition };
              }
              this.options[type + 's'][id] = definition;
              return definition;
            }
          };
        });
      }

      function _getComponentName(opts) {
        return opts && (getComponentName(opts.Ctor.options) || opts.tag);
      }
      function matches(pattern, name) {
        if (isArray(pattern)) {
          return pattern.indexOf(name) > -1;
        }
        else if (typeof pattern === 'string') {
          return pattern.split(',').indexOf(name) > -1;
        }
        else if (isRegExp(pattern)) {
          return pattern.test(name);
        }
        /* istanbul ignore next */
        return false;
      }
      function pruneCache(keepAliveInstance, filter) {
        var cache = keepAliveInstance.cache, keys = keepAliveInstance.keys, _vnode = keepAliveInstance._vnode;
        for (var key in cache) {
          var entry = cache[key];
          if (entry) {
            var name_1 = entry.name;
            if (name_1 && !filter(name_1)) {
              pruneCacheEntry(cache, key, keys, _vnode);
            }
          }
        }
      }
      function pruneCacheEntry(cache, key, keys, current) {
        var entry = cache[key];
        if (entry && (!current || entry.tag !== current.tag)) {
          // @ts-expect-error can be undefined
          entry.componentInstance.$destroy();
        }
        cache[key] = null;
        remove$2(keys, key);
      }
      var patternTypes = [String, RegExp, Array];
// TODO defineComponent
      var KeepAlive = {
        name: 'keep-alive',
        abstract: true,
        props: {
          include: patternTypes,
          exclude: patternTypes,
          max: [String, Number]
        },
        methods: {
          cacheVNode: function () {
            var _a = this, cache = _a.cache, keys = _a.keys, vnodeToCache = _a.vnodeToCache, keyToCache = _a.keyToCache;
            if (vnodeToCache) {
              var tag = vnodeToCache.tag, componentInstance = vnodeToCache.componentInstance, componentOptions = vnodeToCache.componentOptions;
              cache[keyToCache] = {
                name: _getComponentName(componentOptions),
                tag: tag,
                componentInstance: componentInstance
              };
              keys.push(keyToCache);
              // prune oldest entry
              if (this.max && keys.length > parseInt(this.max)) {
                pruneCacheEntry(cache, keys[0], keys, this._vnode);
              }
              this.vnodeToCache = null;
            }
          }
        },
        created: function () {
          this.cache = Object.create(null);
          this.keys = [];
        },
        destroyed: function () {
          for (var key in this.cache) {
            pruneCacheEntry(this.cache, key, this.keys);
          }
        },
        mounted: function () {
          var _this = this;
          this.cacheVNode();
          this.$watch('include', function (val) {
            pruneCache(_this, function (name) { return matches(val, name); });
          });
          this.$watch('exclude', function (val) {
            pruneCache(_this, function (name) { return !matches(val, name); });
          });
        },
        updated: function () {
          this.cacheVNode();
        },
        render: function () {
          var slot = this.$slots.default;
          var vnode = getFirstComponentChild(slot);
          var componentOptions = vnode && vnode.componentOptions;
          if (componentOptions) {
            // check pattern
            var name_2 = _getComponentName(componentOptions);
            var _a = this, include = _a.include, exclude = _a.exclude;
            if (
                // not included
                (include && (!name_2 || !matches(include, name_2))) ||
                // excluded
                (exclude && name_2 && matches(exclude, name_2))) {
              return vnode;
            }
            var _b = this, cache = _b.cache, keys = _b.keys;
            var key = vnode.key == null
                ? // same constructor may get registered as different local components
                // so cid alone is not enough (#3269)
                componentOptions.Ctor.cid +
                (componentOptions.tag ? "::".concat(componentOptions.tag) : '')
                : vnode.key;
            if (cache[key]) {
              vnode.componentInstance = cache[key].componentInstance;
              // make current key freshest
              remove$2(keys, key);
              keys.push(key);
            }
            else {
              // delay setting the cache until update
              this.vnodeToCache = vnode;
              this.keyToCache = key;
            }
            // @ts-expect-error can vnode.data can be undefined
            vnode.data.keepAlive = true;
          }
          return vnode || (slot && slot[0]);
        }
      };

      var builtInComponents = {
        KeepAlive: KeepAlive
      };

      function initGlobalAPI(Vue) {
        // config
        var configDef = {};
        configDef.get = function () { return config; };
        if (true) {
          configDef.set = function () {
            warn$2('Do not replace the Vue.config object, set individual fields instead.');
          };
        }
        Object.defineProperty(Vue, 'config', configDef);
        // exposed util methods.
        // NOTE: these are not considered part of the public API - avoid relying on
        // them unless you are aware of the risk.
        Vue.util = {
          warn: warn$2,
          extend: extend,
          mergeOptions: mergeOptions,
          defineReactive: defineReactive
        };
        Vue.set = set;
        Vue.delete = del;
        Vue.nextTick = nextTick;
        // 2.6 explicit observable API
        Vue.observable = function (obj) {
          observe(obj);
          return obj;
        };
        Vue.options = Object.create(null);
        ASSET_TYPES.forEach(function (type) {
          Vue.options[type + 's'] = Object.create(null);
        });
        // this is used to identify the "base" constructor to extend all plain-object
        // components with in Weex's multi-instance scenarios.
        Vue.options._base = Vue;
        extend(Vue.options.components, builtInComponents);
        initUse(Vue);
        initMixin(Vue);
        initExtend(Vue);
        initAssetRegisters(Vue);
      }

      initGlobalAPI(Vue);
      Object.defineProperty(Vue.prototype, '$isServer', {
        get: isServerRendering
      });
      Object.defineProperty(Vue.prototype, '$ssrContext', {
        get: function () {
          /* istanbul ignore next */
          return this.$vnode && this.$vnode.ssrContext;
        }
      });
// expose FunctionalRenderContext for ssr runtime helper installation
      Object.defineProperty(Vue, 'FunctionalRenderContext', {
        value: FunctionalRenderContext
      });
      Vue.version = version;

// these are reserved for web because they are directly compiled away
// during template compilation
      var isReservedAttr = makeMap('style,class');
// attributes that should be using props for binding
      var acceptValue = makeMap('input,textarea,option,select,progress');
      var mustUseProp = function (tag, type, attr) {
        return ((attr === 'value' && acceptValue(tag) && type !== 'button') ||
            (attr === 'selected' && tag === 'option') ||
            (attr === 'checked' && tag === 'input') ||
            (attr === 'muted' && tag === 'video'));
      };
      var isEnumeratedAttr = makeMap('contenteditable,draggable,spellcheck');
      var isValidContentEditableValue = makeMap('events,caret,typing,plaintext-only');
      var convertEnumeratedValue = function (key, value) {
        return isFalsyAttrValue(value) || value === 'false'
            ? 'false'
            : // allow arbitrary string value for contenteditable
            key === 'contenteditable' && isValidContentEditableValue(value)
                ? value
                : 'true';
      };
      var isBooleanAttr = makeMap('allowfullscreen,async,autofocus,autoplay,checked,compact,controls,declare,' +
          'default,defaultchecked,defaultmuted,defaultselected,defer,disabled,' +
          'enabled,formnovalidate,hidden,indeterminate,inert,ismap,itemscope,loop,multiple,' +
          'muted,nohref,noresize,noshade,novalidate,nowrap,open,pauseonexit,readonly,' +
          'required,reversed,scoped,seamless,selected,sortable,' +
          'truespeed,typemustmatch,visible');
      var xlinkNS = 'http://www.w3.org/1999/xlink';
      var isXlink = function (name) {
        return name.charAt(5) === ':' && name.slice(0, 5) === 'xlink';
      };
      var getXlinkProp = function (name) {
        return isXlink(name) ? name.slice(6, name.length) : '';
      };
      var isFalsyAttrValue = function (val) {
        return val == null || val === false;
      };

      function genClassForVnode(vnode) {
        var data = vnode.data;
        var parentNode = vnode;
        var childNode = vnode;
        while (isDef(childNode.componentInstance)) {
          childNode = childNode.componentInstance._vnode;
          if (childNode && childNode.data) {
            data = mergeClassData(childNode.data, data);
          }
        }
        // @ts-expect-error parentNode.parent not VNodeWithData
        while (isDef((parentNode = parentNode.parent))) {
          if (parentNode && parentNode.data) {
            data = mergeClassData(data, parentNode.data);
          }
        }
        return renderClass(data.staticClass, data.class);
      }
      function mergeClassData(child, parent) {
        return {
          staticClass: concat(child.staticClass, parent.staticClass),
          class: isDef(child.class) ? [child.class, parent.class] : parent.class
        };
      }
      function renderClass(staticClass, dynamicClass) {
        if (isDef(staticClass) || isDef(dynamicClass)) {
          return concat(staticClass, stringifyClass(dynamicClass));
        }
        /* istanbul ignore next */
        return '';
      }
      function concat(a, b) {
        return a ? (b ? a + ' ' + b : a) : b || '';
      }
      function stringifyClass(value) {
        if (Array.isArray(value)) {
          return stringifyArray(value);
        }
        if (isObject(value)) {
          return stringifyObject(value);
        }
        if (typeof value === 'string') {
          return value;
        }
        /* istanbul ignore next */
        return '';
      }
      function stringifyArray(value) {
        var res = '';
        var stringified;
        for (var i = 0, l = value.length; i < l; i++) {
          if (isDef((stringified = stringifyClass(value[i]))) && stringified !== '') {
            if (res)
              res += ' ';
            res += stringified;
          }
        }
        return res;
      }
      function stringifyObject(value) {
        var res = '';
        for (var key in value) {
          if (value[key]) {
            if (res)
              res += ' ';
            res += key;
          }
        }
        return res;
      }

      var namespaceMap = {
        svg: 'http://www.w3.org/2000/svg',
        math: 'http://www.w3.org/1998/Math/MathML'
      };
      var isHTMLTag = makeMap('html,body,base,head,link,meta,style,title,' +
          'address,article,aside,footer,header,h1,h2,h3,h4,h5,h6,hgroup,nav,section,' +
          'div,dd,dl,dt,figcaption,figure,picture,hr,img,li,main,ol,p,pre,ul,' +
          'a,b,abbr,bdi,bdo,br,cite,code,data,dfn,em,i,kbd,mark,q,rp,rt,rtc,ruby,' +
          's,samp,small,span,strong,sub,sup,time,u,var,wbr,area,audio,map,track,video,' +
          'embed,object,param,source,canvas,script,noscript,del,ins,' +
          'caption,col,colgroup,table,thead,tbody,td,th,tr,' +
          'button,datalist,fieldset,form,input,label,legend,meter,optgroup,option,' +
          'output,progress,select,textarea,' +
          'details,dialog,menu,menuitem,summary,' +
          'content,element,shadow,template,blockquote,iframe,tfoot');
// this map is intentionally selective, only covering SVG elements that may
// contain child elements.
      var isSVG = makeMap('svg,animate,circle,clippath,cursor,defs,desc,ellipse,filter,font-face,' +
          'foreignobject,g,glyph,image,line,marker,mask,missing-glyph,path,pattern,' +
          'polygon,polyline,rect,switch,symbol,text,textpath,tspan,use,view', true);
      var isPreTag = function (tag) { return tag === 'pre'; };
      var isReservedTag = function (tag) {
        return isHTMLTag(tag) || isSVG(tag);
      };
      function getTagNamespace(tag) {
        if (isSVG(tag)) {
          return 'svg';
        }
        // basic support for MathML
        // note it doesn't support other MathML elements being component roots
        if (tag === 'math') {
          return 'math';
        }
      }
      var unknownElementCache = Object.create(null);
      function isUnknownElement(tag) {
        /* istanbul ignore if */
        if (!inBrowser) {
          return true;
        }
        if (isReservedTag(tag)) {
          return false;
        }
        tag = tag.toLowerCase();
        /* istanbul ignore if */
        if (unknownElementCache[tag] != null) {
          return unknownElementCache[tag];
        }
        var el = document.createElement(tag);
        if (tag.indexOf('-') > -1) {
          // http://stackoverflow.com/a/28210364/1070244
          return (unknownElementCache[tag] =
              el.constructor === window.HTMLUnknownElement ||
              el.constructor === window.HTMLElement);
        }
        else {
          return (unknownElementCache[tag] = /HTMLUnknownElement/.test(el.toString()));
        }
      }
      var isTextInputType = makeMap('text,number,password,search,email,tel,url');

      /**
       * Query an element selector if it's not an element already.
       */
      function query(el) {
        if (typeof el === 'string') {
          var selected = document.querySelector(el);
          if (!selected) {
            true && warn$2('Cannot find element: ' + el);
            return document.createElement('div');
          }
          return selected;
        }
        else {
          return el;
        }
      }

      function createElement(tagName, vnode) {
        var elm = document.createElement(tagName);
        if (tagName !== 'select') {
          return elm;
        }
        // false or null will remove the attribute but undefined will not
        if (vnode.data &&
            vnode.data.attrs &&
            vnode.data.attrs.multiple !== undefined) {
          elm.setAttribute('multiple', 'multiple');
        }
        return elm;
      }
      function createElementNS(namespace, tagName) {
        return document.createElementNS(namespaceMap[namespace], tagName);
      }
      function createTextNode(text) {
        return document.createTextNode(text);
      }
      function createComment(text) {
        return document.createComment(text);
      }
      function insertBefore(parentNode, newNode, referenceNode) {
        parentNode.insertBefore(newNode, referenceNode);
      }
      function removeChild(node, child) {
        node.removeChild(child);
      }
      function appendChild(node, child) {
        node.appendChild(child);
      }
      function parentNode(node) {
        return node.parentNode;
      }
      function nextSibling(node) {
        return node.nextSibling;
      }
      function tagName(node) {
        return node.tagName;
      }
      function setTextContent(node, text) {
        node.textContent = text;
      }
      function setStyleScope(node, scopeId) {
        node.setAttribute(scopeId, '');
      }

      var nodeOps = /*#__PURE__*/Object.freeze({
        __proto__: null,
        createElement: createElement,
        createElementNS: createElementNS,
        createTextNode: createTextNode,
        createComment: createComment,
        insertBefore: insertBefore,
        removeChild: removeChild,
        appendChild: appendChild,
        parentNode: parentNode,
        nextSibling: nextSibling,
        tagName: tagName,
        setTextContent: setTextContent,
        setStyleScope: setStyleScope
      });

      var ref = {
        create: function (_, vnode) {
          registerRef(vnode);
        },
        update: function (oldVnode, vnode) {
          if (oldVnode.data.ref !== vnode.data.ref) {
            registerRef(oldVnode, true);
            registerRef(vnode);
          }
        },
        destroy: function (vnode) {
          registerRef(vnode, true);
        }
      };
      function registerRef(vnode, isRemoval) {
        var ref = vnode.data.ref;
        if (!isDef(ref))
          return;
        var vm = vnode.context;
        var refValue = vnode.componentInstance || vnode.elm;
        var value = isRemoval ? null : refValue;
        var $refsValue = isRemoval ? undefined : refValue;
        if (isFunction(ref)) {
          invokeWithErrorHandling(ref, vm, [value], vm, "template ref function");
          return;
        }
        var isFor = vnode.data.refInFor;
        var _isString = typeof ref === 'string' || typeof ref === 'number';
        var _isRef = isRef(ref);
        var refs = vm.$refs;
        if (_isString || _isRef) {
          if (isFor) {
            var existing = _isString ? refs[ref] : ref.value;
            if (isRemoval) {
              isArray(existing) && remove$2(existing, refValue);
            }
            else {
              if (!isArray(existing)) {
                if (_isString) {
                  refs[ref] = [refValue];
                  setSetupRef(vm, ref, refs[ref]);
                }
                else {
                  ref.value = [refValue];
                }
              }
              else if (!existing.includes(refValue)) {
                existing.push(refValue);
              }
            }
          }
          else if (_isString) {
            if (isRemoval && refs[ref] !== refValue) {
              return;
            }
            refs[ref] = $refsValue;
            setSetupRef(vm, ref, value);
          }
          else if (_isRef) {
            if (isRemoval && ref.value !== refValue) {
              return;
            }
            ref.value = value;
          }
          else if (true) {
            warn$2("Invalid template ref type: ".concat(typeof ref));
          }
        }
      }
      function setSetupRef(_a, key, val) {
        var _setupState = _a._setupState;
        if (_setupState && hasOwn(_setupState, key)) {
          if (isRef(_setupState[key])) {
            _setupState[key].value = val;
          }
          else {
            _setupState[key] = val;
          }
        }
      }

      /**
       * Virtual DOM patching algorithm based on Snabbdom by
       * Simon Friis Vindum (@paldepind)
       * Licensed under the MIT License
       * https://github.com/paldepind/snabbdom/blob/master/LICENSE
       *
       * modified by Evan You (@yyx990803)
       *
       * Not type-checking this because this file is perf-critical and the cost
       * of making flow understand it is not worth it.
       */
      var emptyNode = new VNode('', {}, []);
      var hooks = ['create', 'activate', 'update', 'remove', 'destroy'];
      function sameVnode(a, b) {
        return (a.key === b.key &&
            a.asyncFactory === b.asyncFactory &&
            ((a.tag === b.tag &&
                a.isComment === b.isComment &&
                isDef(a.data) === isDef(b.data) &&
                sameInputType(a, b)) ||
                (isTrue(a.isAsyncPlaceholder) && isUndef(b.asyncFactory.error))));
      }
      function sameInputType(a, b) {
        if (a.tag !== 'input')
          return true;
        var i;
        var typeA = isDef((i = a.data)) && isDef((i = i.attrs)) && i.type;
        var typeB = isDef((i = b.data)) && isDef((i = i.attrs)) && i.type;
        return typeA === typeB || (isTextInputType(typeA) && isTextInputType(typeB));
      }
      function createKeyToOldIdx(children, beginIdx, endIdx) {
        var i, key;
        var map = {};
        for (i = beginIdx; i <= endIdx; ++i) {
          key = children[i].key;
          if (isDef(key))
            map[key] = i;
        }
        return map;
      }
      function createPatchFunction(backend) {
        var i, j;
        var cbs = {};
        var modules = backend.modules, nodeOps = backend.nodeOps;
        for (i = 0; i < hooks.length; ++i) {
          cbs[hooks[i]] = [];
          for (j = 0; j < modules.length; ++j) {
            if (isDef(modules[j][hooks[i]])) {
              cbs[hooks[i]].push(modules[j][hooks[i]]);
            }
          }
        }
        function emptyNodeAt(elm) {
          return new VNode(nodeOps.tagName(elm).toLowerCase(), {}, [], undefined, elm);
        }
        function createRmCb(childElm, listeners) {
          function remove() {
            if (--remove.listeners === 0) {
              removeNode(childElm);
            }
          }
          remove.listeners = listeners;
          return remove;
        }
        function removeNode(el) {
          var parent = nodeOps.parentNode(el);
          // element may have already been removed due to v-html / v-text
          if (isDef(parent)) {
            nodeOps.removeChild(parent, el);
          }
        }
        function isUnknownElement(vnode, inVPre) {
          return (!inVPre &&
              !vnode.ns &&
              !(config.ignoredElements.length &&
                  config.ignoredElements.some(function (ignore) {
                    return isRegExp(ignore)
                        ? ignore.test(vnode.tag)
                        : ignore === vnode.tag;
                  })) &&
              config.isUnknownElement(vnode.tag));
        }
        var creatingElmInVPre = 0;
        function createElm(vnode, insertedVnodeQueue, parentElm, refElm, nested, ownerArray, index) {
          if (isDef(vnode.elm) && isDef(ownerArray)) {
            // This vnode was used in a previous render!
            // now it's used as a new node, overwriting its elm would cause
            // potential patch errors down the road when it's used as an insertion
            // reference node. Instead, we clone the node on-demand before creating
            // associated DOM element for it.
            vnode = ownerArray[index] = cloneVNode(vnode);
          }
          vnode.isRootInsert = !nested; // for transition enter check
          if (createComponent(vnode, insertedVnodeQueue, parentElm, refElm)) {
            return;
          }
          var data = vnode.data;
          var children = vnode.children;
          var tag = vnode.tag;
          if (isDef(tag)) {
            if (true) {
              if (data && data.pre) {
                creatingElmInVPre++;
              }
              if (isUnknownElement(vnode, creatingElmInVPre)) {
                warn$2('Unknown custom element: <' +
                    tag +
                    '> - did you ' +
                    'register the component correctly? For recursive components, ' +
                    'make sure to provide the "name" option.', vnode.context);
              }
            }
            vnode.elm = vnode.ns
                ? nodeOps.createElementNS(vnode.ns, tag)
                : nodeOps.createElement(tag, vnode);
            setScope(vnode);
            createChildren(vnode, children, insertedVnodeQueue);
            if (isDef(data)) {
              invokeCreateHooks(vnode, insertedVnodeQueue);
            }
            insert(parentElm, vnode.elm, refElm);
            if ( true && data && data.pre) {
              creatingElmInVPre--;
            }
          }
          else if (isTrue(vnode.isComment)) {
            vnode.elm = nodeOps.createComment(vnode.text);
            insert(parentElm, vnode.elm, refElm);
          }
          else {
            vnode.elm = nodeOps.createTextNode(vnode.text);
            insert(parentElm, vnode.elm, refElm);
          }
        }
        function createComponent(vnode, insertedVnodeQueue, parentElm, refElm) {
          var i = vnode.data;
          if (isDef(i)) {
            var isReactivated = isDef(vnode.componentInstance) && i.keepAlive;
            if (isDef((i = i.hook)) && isDef((i = i.init))) {
              i(vnode, false /* hydrating */);
            }
            // after calling the init hook, if the vnode is a child component
            // it should've created a child instance and mounted it. the child
            // component also has set the placeholder vnode's elm.
            // in that case we can just return the element and be done.
            if (isDef(vnode.componentInstance)) {
              initComponent(vnode, insertedVnodeQueue);
              insert(parentElm, vnode.elm, refElm);
              if (isTrue(isReactivated)) {
                reactivateComponent(vnode, insertedVnodeQueue, parentElm, refElm);
              }
              return true;
            }
          }
        }
        function initComponent(vnode, insertedVnodeQueue) {
          if (isDef(vnode.data.pendingInsert)) {
            insertedVnodeQueue.push.apply(insertedVnodeQueue, vnode.data.pendingInsert);
            vnode.data.pendingInsert = null;
          }
          vnode.elm = vnode.componentInstance.$el;
          if (isPatchable(vnode)) {
            invokeCreateHooks(vnode, insertedVnodeQueue);
            setScope(vnode);
          }
          else {
            // empty component root.
            // skip all element-related modules except for ref (#3455)
            registerRef(vnode);
            // make sure to invoke the insert hook
            insertedVnodeQueue.push(vnode);
          }
        }
        function reactivateComponent(vnode, insertedVnodeQueue, parentElm, refElm) {
          var i;
          // hack for #4339: a reactivated component with inner transition
          // does not trigger because the inner node's created hooks are not called
          // again. It's not ideal to involve module-specific logic in here but
          // there doesn't seem to be a better way to do it.
          var innerNode = vnode;
          while (innerNode.componentInstance) {
            innerNode = innerNode.componentInstance._vnode;
            if (isDef((i = innerNode.data)) && isDef((i = i.transition))) {
              for (i = 0; i < cbs.activate.length; ++i) {
                cbs.activate[i](emptyNode, innerNode);
              }
              insertedVnodeQueue.push(innerNode);
              break;
            }
          }
          // unlike a newly created component,
          // a reactivated keep-alive component doesn't insert itself
          insert(parentElm, vnode.elm, refElm);
        }
        function insert(parent, elm, ref) {
          if (isDef(parent)) {
            if (isDef(ref)) {
              if (nodeOps.parentNode(ref) === parent) {
                nodeOps.insertBefore(parent, elm, ref);
              }
            }
            else {
              nodeOps.appendChild(parent, elm);
            }
          }
        }
        function createChildren(vnode, children, insertedVnodeQueue) {
          if (isArray(children)) {
            if (true) {
              checkDuplicateKeys(children);
            }
            for (var i_1 = 0; i_1 < children.length; ++i_1) {
              createElm(children[i_1], insertedVnodeQueue, vnode.elm, null, true, children, i_1);
            }
          }
          else if (isPrimitive(vnode.text)) {
            nodeOps.appendChild(vnode.elm, nodeOps.createTextNode(String(vnode.text)));
          }
        }
        function isPatchable(vnode) {
          while (vnode.componentInstance) {
            vnode = vnode.componentInstance._vnode;
          }
          return isDef(vnode.tag);
        }
        function invokeCreateHooks(vnode, insertedVnodeQueue) {
          for (var i_2 = 0; i_2 < cbs.create.length; ++i_2) {
            cbs.create[i_2](emptyNode, vnode);
          }
          i = vnode.data.hook; // Reuse variable
          if (isDef(i)) {
            if (isDef(i.create))
              i.create(emptyNode, vnode);
            if (isDef(i.insert))
              insertedVnodeQueue.push(vnode);
          }
        }
        // set scope id attribute for scoped CSS.
        // this is implemented as a special case to avoid the overhead
        // of going through the normal attribute patching process.
        function setScope(vnode) {
          var i;
          if (isDef((i = vnode.fnScopeId))) {
            nodeOps.setStyleScope(vnode.elm, i);
          }
          else {
            var ancestor = vnode;
            while (ancestor) {
              if (isDef((i = ancestor.context)) && isDef((i = i.$options._scopeId))) {
                nodeOps.setStyleScope(vnode.elm, i);
              }
              ancestor = ancestor.parent;
            }
          }
          // for slot content they should also get the scopeId from the host instance.
          if (isDef((i = activeInstance)) &&
              i !== vnode.context &&
              i !== vnode.fnContext &&
              isDef((i = i.$options._scopeId))) {
            nodeOps.setStyleScope(vnode.elm, i);
          }
        }
        function addVnodes(parentElm, refElm, vnodes, startIdx, endIdx, insertedVnodeQueue) {
          for (; startIdx <= endIdx; ++startIdx) {
            createElm(vnodes[startIdx], insertedVnodeQueue, parentElm, refElm, false, vnodes, startIdx);
          }
        }
        function invokeDestroyHook(vnode) {
          var i, j;
          var data = vnode.data;
          if (isDef(data)) {
            if (isDef((i = data.hook)) && isDef((i = i.destroy)))
              i(vnode);
            for (i = 0; i < cbs.destroy.length; ++i)
              cbs.destroy[i](vnode);
          }
          if (isDef((i = vnode.children))) {
            for (j = 0; j < vnode.children.length; ++j) {
              invokeDestroyHook(vnode.children[j]);
            }
          }
        }
        function removeVnodes(vnodes, startIdx, endIdx) {
          for (; startIdx <= endIdx; ++startIdx) {
            var ch = vnodes[startIdx];
            if (isDef(ch)) {
              if (isDef(ch.tag)) {
                removeAndInvokeRemoveHook(ch);
                invokeDestroyHook(ch);
              }
              else {
                // Text node
                removeNode(ch.elm);
              }
            }
          }
        }
        function removeAndInvokeRemoveHook(vnode, rm) {
          if (isDef(rm) || isDef(vnode.data)) {
            var i_3;
            var listeners = cbs.remove.length + 1;
            if (isDef(rm)) {
              // we have a recursively passed down rm callback
              // increase the listeners count
              rm.listeners += listeners;
            }
            else {
              // directly removing
              rm = createRmCb(vnode.elm, listeners);
            }
            // recursively invoke hooks on child component root node
            if (isDef((i_3 = vnode.componentInstance)) &&
                isDef((i_3 = i_3._vnode)) &&
                isDef(i_3.data)) {
              removeAndInvokeRemoveHook(i_3, rm);
            }
            for (i_3 = 0; i_3 < cbs.remove.length; ++i_3) {
              cbs.remove[i_3](vnode, rm);
            }
            if (isDef((i_3 = vnode.data.hook)) && isDef((i_3 = i_3.remove))) {
              i_3(vnode, rm);
            }
            else {
              rm();
            }
          }
          else {
            removeNode(vnode.elm);
          }
        }
        function updateChildren(parentElm, oldCh, newCh, insertedVnodeQueue, removeOnly) {
          var oldStartIdx = 0;
          var newStartIdx = 0;
          var oldEndIdx = oldCh.length - 1;
          var oldStartVnode = oldCh[0];
          var oldEndVnode = oldCh[oldEndIdx];
          var newEndIdx = newCh.length - 1;
          var newStartVnode = newCh[0];
          var newEndVnode = newCh[newEndIdx];
          var oldKeyToIdx, idxInOld, vnodeToMove, refElm;
          // removeOnly is a special flag used only by <transition-group>
          // to ensure removed elements stay in correct relative positions
          // during leaving transitions
          var canMove = !removeOnly;
          if (true) {
            checkDuplicateKeys(newCh);
          }
          while (oldStartIdx <= oldEndIdx && newStartIdx <= newEndIdx) {
            if (isUndef(oldStartVnode)) {
              oldStartVnode = oldCh[++oldStartIdx]; // Vnode has been moved left
            }
            else if (isUndef(oldEndVnode)) {
              oldEndVnode = oldCh[--oldEndIdx];
            }
            else if (sameVnode(oldStartVnode, newStartVnode)) {
              patchVnode(oldStartVnode, newStartVnode, insertedVnodeQueue, newCh, newStartIdx);
              oldStartVnode = oldCh[++oldStartIdx];
              newStartVnode = newCh[++newStartIdx];
            }
            else if (sameVnode(oldEndVnode, newEndVnode)) {
              patchVnode(oldEndVnode, newEndVnode, insertedVnodeQueue, newCh, newEndIdx);
              oldEndVnode = oldCh[--oldEndIdx];
              newEndVnode = newCh[--newEndIdx];
            }
            else if (sameVnode(oldStartVnode, newEndVnode)) {
              // Vnode moved right
              patchVnode(oldStartVnode, newEndVnode, insertedVnodeQueue, newCh, newEndIdx);
              canMove &&
              nodeOps.insertBefore(parentElm, oldStartVnode.elm, nodeOps.nextSibling(oldEndVnode.elm));
              oldStartVnode = oldCh[++oldStartIdx];
              newEndVnode = newCh[--newEndIdx];
            }
            else if (sameVnode(oldEndVnode, newStartVnode)) {
              // Vnode moved left
              patchVnode(oldEndVnode, newStartVnode, insertedVnodeQueue, newCh, newStartIdx);
              canMove &&
              nodeOps.insertBefore(parentElm, oldEndVnode.elm, oldStartVnode.elm);
              oldEndVnode = oldCh[--oldEndIdx];
              newStartVnode = newCh[++newStartIdx];
            }
            else {
              if (isUndef(oldKeyToIdx))
                oldKeyToIdx = createKeyToOldIdx(oldCh, oldStartIdx, oldEndIdx);
              idxInOld = isDef(newStartVnode.key)
                  ? oldKeyToIdx[newStartVnode.key]
                  : findIdxInOld(newStartVnode, oldCh, oldStartIdx, oldEndIdx);
              if (isUndef(idxInOld)) {
                // New element
                createElm(newStartVnode, insertedVnodeQueue, parentElm, oldStartVnode.elm, false, newCh, newStartIdx);
              }
              else {
                vnodeToMove = oldCh[idxInOld];
                if (sameVnode(vnodeToMove, newStartVnode)) {
                  patchVnode(vnodeToMove, newStartVnode, insertedVnodeQueue, newCh, newStartIdx);
                  oldCh[idxInOld] = undefined;
                  canMove &&
                  nodeOps.insertBefore(parentElm, vnodeToMove.elm, oldStartVnode.elm);
                }
                else {
                  // same key but different element. treat as new element
                  createElm(newStartVnode, insertedVnodeQueue, parentElm, oldStartVnode.elm, false, newCh, newStartIdx);
                }
              }
              newStartVnode = newCh[++newStartIdx];
            }
          }
          if (oldStartIdx > oldEndIdx) {
            refElm = isUndef(newCh[newEndIdx + 1]) ? null : newCh[newEndIdx + 1].elm;
            addVnodes(parentElm, refElm, newCh, newStartIdx, newEndIdx, insertedVnodeQueue);
          }
          else if (newStartIdx > newEndIdx) {
            removeVnodes(oldCh, oldStartIdx, oldEndIdx);
          }
        }
        function checkDuplicateKeys(children) {
          var seenKeys = {};
          for (var i_4 = 0; i_4 < children.length; i_4++) {
            var vnode = children[i_4];
            var key = vnode.key;
            if (isDef(key)) {
              if (seenKeys[key]) {
                warn$2("Duplicate keys detected: '".concat(key, "'. This may cause an update error."), vnode.context);
              }
              else {
                seenKeys[key] = true;
              }
            }
          }
        }
        function findIdxInOld(node, oldCh, start, end) {
          for (var i_5 = start; i_5 < end; i_5++) {
            var c = oldCh[i_5];
            if (isDef(c) && sameVnode(node, c))
              return i_5;
          }
        }
        function patchVnode(oldVnode, vnode, insertedVnodeQueue, ownerArray, index, removeOnly) {
          if (oldVnode === vnode) {
            return;
          }
          if (isDef(vnode.elm) && isDef(ownerArray)) {
            // clone reused vnode
            vnode = ownerArray[index] = cloneVNode(vnode);
          }
          var elm = (vnode.elm = oldVnode.elm);
          if (isTrue(oldVnode.isAsyncPlaceholder)) {
            if (isDef(vnode.asyncFactory.resolved)) {
              hydrate(oldVnode.elm, vnode, insertedVnodeQueue);
            }
            else {
              vnode.isAsyncPlaceholder = true;
            }
            return;
          }
          // reuse element for static trees.
          // note we only do this if the vnode is cloned -
          // if the new node is not cloned it means the render functions have been
          // reset by the hot-reload-api and we need to do a proper re-render.
          if (isTrue(vnode.isStatic) &&
              isTrue(oldVnode.isStatic) &&
              vnode.key === oldVnode.key &&
              (isTrue(vnode.isCloned) || isTrue(vnode.isOnce))) {
            vnode.componentInstance = oldVnode.componentInstance;
            return;
          }
          var i;
          var data = vnode.data;
          if (isDef(data) && isDef((i = data.hook)) && isDef((i = i.prepatch))) {
            i(oldVnode, vnode);
          }
          var oldCh = oldVnode.children;
          var ch = vnode.children;
          if (isDef(data) && isPatchable(vnode)) {
            for (i = 0; i < cbs.update.length; ++i)
              cbs.update[i](oldVnode, vnode);
            if (isDef((i = data.hook)) && isDef((i = i.update)))
              i(oldVnode, vnode);
          }
          if (isUndef(vnode.text)) {
            if (isDef(oldCh) && isDef(ch)) {
              if (oldCh !== ch)
                updateChildren(elm, oldCh, ch, insertedVnodeQueue, removeOnly);
            }
            else if (isDef(ch)) {
              if (true) {
                checkDuplicateKeys(ch);
              }
              if (isDef(oldVnode.text))
                nodeOps.setTextContent(elm, '');
              addVnodes(elm, null, ch, 0, ch.length - 1, insertedVnodeQueue);
            }
            else if (isDef(oldCh)) {
              removeVnodes(oldCh, 0, oldCh.length - 1);
            }
            else if (isDef(oldVnode.text)) {
              nodeOps.setTextContent(elm, '');
            }
          }
          else if (oldVnode.text !== vnode.text) {
            nodeOps.setTextContent(elm, vnode.text);
          }
          if (isDef(data)) {
            if (isDef((i = data.hook)) && isDef((i = i.postpatch)))
              i(oldVnode, vnode);
          }
        }
        function invokeInsertHook(vnode, queue, initial) {
          // delay insert hooks for component root nodes, invoke them after the
          // element is really inserted
          if (isTrue(initial) && isDef(vnode.parent)) {
            vnode.parent.data.pendingInsert = queue;
          }
          else {
            for (var i_6 = 0; i_6 < queue.length; ++i_6) {
              queue[i_6].data.hook.insert(queue[i_6]);
            }
          }
        }
        var hydrationBailed = false;
        // list of modules that can skip create hook during hydration because they
        // are already rendered on the client or has no need for initialization
        // Note: style is excluded because it relies on initial clone for future
        // deep updates (#7063).
        var isRenderedModule = makeMap('attrs,class,staticClass,staticStyle,key');
        // Note: this is a browser-only function so we can assume elms are DOM nodes.
        function hydrate(elm, vnode, insertedVnodeQueue, inVPre) {
          var i;
          var tag = vnode.tag, data = vnode.data, children = vnode.children;
          inVPre = inVPre || (data && data.pre);
          vnode.elm = elm;
          if (isTrue(vnode.isComment) && isDef(vnode.asyncFactory)) {
            vnode.isAsyncPlaceholder = true;
            return true;
          }
          // assert node match
          if (true) {
            if (!assertNodeMatch(elm, vnode, inVPre)) {
              return false;
            }
          }
          if (isDef(data)) {
            if (isDef((i = data.hook)) && isDef((i = i.init)))
              i(vnode, true /* hydrating */);
            if (isDef((i = vnode.componentInstance))) {
              // child component. it should have hydrated its own tree.
              initComponent(vnode, insertedVnodeQueue);
              return true;
            }
          }
          if (isDef(tag)) {
            if (isDef(children)) {
              // empty element, allow client to pick up and populate children
              if (!elm.hasChildNodes()) {
                createChildren(vnode, children, insertedVnodeQueue);
              }
              else {
                // v-html and domProps: innerHTML
                if (isDef((i = data)) &&
                    isDef((i = i.domProps)) &&
                    isDef((i = i.innerHTML))) {
                  if (i !== elm.innerHTML) {
                    /* istanbul ignore if */
                    if ( true &&
                        typeof console !== 'undefined' &&
                        !hydrationBailed) {
                      hydrationBailed = true;
                      console.warn('Parent: ', elm);
                      console.warn('server innerHTML: ', i);
                      console.warn('client innerHTML: ', elm.innerHTML);
                    }
                    return false;
                  }
                }
                else {
                  // iterate and compare children lists
                  var childrenMatch = true;
                  var childNode = elm.firstChild;
                  for (var i_7 = 0; i_7 < children.length; i_7++) {
                    if (!childNode ||
                        !hydrate(childNode, children[i_7], insertedVnodeQueue, inVPre)) {
                      childrenMatch = false;
                      break;
                    }
                    childNode = childNode.nextSibling;
                  }
                  // if childNode is not null, it means the actual childNodes list is
                  // longer than the virtual children list.
                  if (!childrenMatch || childNode) {
                    /* istanbul ignore if */
                    if ( true &&
                        typeof console !== 'undefined' &&
                        !hydrationBailed) {
                      hydrationBailed = true;
                      console.warn('Parent: ', elm);
                      console.warn('Mismatching childNodes vs. VNodes: ', elm.childNodes, children);
                    }
                    return false;
                  }
                }
              }
            }
            if (isDef(data)) {
              var fullInvoke = false;
              for (var key in data) {
                if (!isRenderedModule(key)) {
                  fullInvoke = true;
                  invokeCreateHooks(vnode, insertedVnodeQueue);
                  break;
                }
              }
              if (!fullInvoke && data['class']) {
                // ensure collecting deps for deep class bindings for future updates
                traverse(data['class']);
              }
            }
          }
          else if (elm.data !== vnode.text) {
            elm.data = vnode.text;
          }
          return true;
        }
        function assertNodeMatch(node, vnode, inVPre) {
          if (isDef(vnode.tag)) {
            return (vnode.tag.indexOf('vue-component') === 0 ||
                (!isUnknownElement(vnode, inVPre) &&
                    vnode.tag.toLowerCase() ===
                    (node.tagName && node.tagName.toLowerCase())));
          }
          else {
            return node.nodeType === (vnode.isComment ? 8 : 3);
          }
        }
        return function patch(oldVnode, vnode, hydrating, removeOnly) {
          if (isUndef(vnode)) {
            if (isDef(oldVnode))
              invokeDestroyHook(oldVnode);
            return;
          }
          var isInitialPatch = false;
          var insertedVnodeQueue = [];
          if (isUndef(oldVnode)) {
            // empty mount (likely as component), create new root element
            isInitialPatch = true;
            createElm(vnode, insertedVnodeQueue);
          }
          else {
            var isRealElement = isDef(oldVnode.nodeType);
            if (!isRealElement && sameVnode(oldVnode, vnode)) {
              // patch existing root node
              patchVnode(oldVnode, vnode, insertedVnodeQueue, null, null, removeOnly);
            }
            else {
              if (isRealElement) {
                // mounting to a real element
                // check if this is server-rendered content and if we can perform
                // a successful hydration.
                if (oldVnode.nodeType === 1 && oldVnode.hasAttribute(SSR_ATTR)) {
                  oldVnode.removeAttribute(SSR_ATTR);
                  hydrating = true;
                }
                if (isTrue(hydrating)) {
                  if (hydrate(oldVnode, vnode, insertedVnodeQueue)) {
                    invokeInsertHook(vnode, insertedVnodeQueue, true);
                    return oldVnode;
                  }
                  else if (true) {
                    warn$2('The client-side rendered virtual DOM tree is not matching ' +
                        'server-rendered content. This is likely caused by incorrect ' +
                        'HTML markup, for example nesting block-level elements inside ' +
                        '<p>, or missing <tbody>. Bailing hydration and performing ' +
                        'full client-side render.');
                  }
                }
                // either not server-rendered, or hydration failed.
                // create an empty node and replace it
                oldVnode = emptyNodeAt(oldVnode);
              }
              // replacing existing element
              var oldElm = oldVnode.elm;
              var parentElm = nodeOps.parentNode(oldElm);
              // create new node
              createElm(vnode, insertedVnodeQueue,
                  // extremely rare edge case: do not insert if old element is in a
                  // leaving transition. Only happens when combining transition +
                  // keep-alive + HOCs. (#4590)
                  oldElm._leaveCb ? null : parentElm, nodeOps.nextSibling(oldElm));
              // update parent placeholder node element, recursively
              if (isDef(vnode.parent)) {
                var ancestor = vnode.parent;
                var patchable = isPatchable(vnode);
                while (ancestor) {
                  for (var i_8 = 0; i_8 < cbs.destroy.length; ++i_8) {
                    cbs.destroy[i_8](ancestor);
                  }
                  ancestor.elm = vnode.elm;
                  if (patchable) {
                    for (var i_9 = 0; i_9 < cbs.create.length; ++i_9) {
                      cbs.create[i_9](emptyNode, ancestor);
                    }
                    // #6513
                    // invoke insert hooks that may have been merged by create hooks.
                    // e.g. for directives that uses the "inserted" hook.
                    var insert_1 = ancestor.data.hook.insert;
                    if (insert_1.merged) {
                      // start at index 1 to avoid re-invoking component mounted hook
                      for (var i_10 = 1; i_10 < insert_1.fns.length; i_10++) {
                        insert_1.fns[i_10]();
                      }
                    }
                  }
                  else {
                    registerRef(ancestor);
                  }
                  ancestor = ancestor.parent;
                }
              }
              // destroy old node
              if (isDef(parentElm)) {
                removeVnodes([oldVnode], 0, 0);
              }
              else if (isDef(oldVnode.tag)) {
                invokeDestroyHook(oldVnode);
              }
            }
          }
          invokeInsertHook(vnode, insertedVnodeQueue, isInitialPatch);
          return vnode.elm;
        };
      }

      var directives$1 = {
        create: updateDirectives,
        update: updateDirectives,
        destroy: function unbindDirectives(vnode) {
          // @ts-expect-error emptyNode is not VNodeWithData
          updateDirectives(vnode, emptyNode);
        }
      };
      function updateDirectives(oldVnode, vnode) {
        if (oldVnode.data.directives || vnode.data.directives) {
          _update(oldVnode, vnode);
        }
      }
      function _update(oldVnode, vnode) {
        var isCreate = oldVnode === emptyNode;
        var isDestroy = vnode === emptyNode;
        var oldDirs = normalizeDirectives(oldVnode.data.directives, oldVnode.context);
        var newDirs = normalizeDirectives(vnode.data.directives, vnode.context);
        var dirsWithInsert = [];
        var dirsWithPostpatch = [];
        var key, oldDir, dir;
        for (key in newDirs) {
          oldDir = oldDirs[key];
          dir = newDirs[key];
          if (!oldDir) {
            // new directive, bind
            callHook(dir, 'bind', vnode, oldVnode);
            if (dir.def && dir.def.inserted) {
              dirsWithInsert.push(dir);
            }
          }
          else {
            // existing directive, update
            dir.oldValue = oldDir.value;
            dir.oldArg = oldDir.arg;
            callHook(dir, 'update', vnode, oldVnode);
            if (dir.def && dir.def.componentUpdated) {
              dirsWithPostpatch.push(dir);
            }
          }
        }
        if (dirsWithInsert.length) {
          var callInsert = function () {
            for (var i = 0; i < dirsWithInsert.length; i++) {
              callHook(dirsWithInsert[i], 'inserted', vnode, oldVnode);
            }
          };
          if (isCreate) {
            mergeVNodeHook(vnode, 'insert', callInsert);
          }
          else {
            callInsert();
          }
        }
        if (dirsWithPostpatch.length) {
          mergeVNodeHook(vnode, 'postpatch', function () {
            for (var i = 0; i < dirsWithPostpatch.length; i++) {
              callHook(dirsWithPostpatch[i], 'componentUpdated', vnode, oldVnode);
            }
          });
        }
        if (!isCreate) {
          for (key in oldDirs) {
            if (!newDirs[key]) {
              // no longer present, unbind
              callHook(oldDirs[key], 'unbind', oldVnode, oldVnode, isDestroy);
            }
          }
        }
      }
      var emptyModifiers = Object.create(null);
      function normalizeDirectives(dirs, vm) {
        var res = Object.create(null);
        if (!dirs) {
          // $flow-disable-line
          return res;
        }
        var i, dir;
        for (i = 0; i < dirs.length; i++) {
          dir = dirs[i];
          if (!dir.modifiers) {
            // $flow-disable-line
            dir.modifiers = emptyModifiers;
          }
          res[getRawDirName(dir)] = dir;
          if (vm._setupState && vm._setupState.__sfc) {
            var setupDef = dir.def || resolveAsset(vm, '_setupState', 'v-' + dir.name);
            if (typeof setupDef === 'function') {
              dir.def = {
                bind: setupDef,
                update: setupDef,
              };
            }
            else {
              dir.def = setupDef;
            }
          }
          dir.def = dir.def || resolveAsset(vm.$options, 'directives', dir.name, true);
        }
        // $flow-disable-line
        return res;
      }
      function getRawDirName(dir) {
        return (dir.rawName || "".concat(dir.name, ".").concat(Object.keys(dir.modifiers || {}).join('.')));
      }
      function callHook(dir, hook, vnode, oldVnode, isDestroy) {
        var fn = dir.def && dir.def[hook];
        if (fn) {
          try {
            fn(vnode.elm, dir, vnode, oldVnode, isDestroy);
          }
          catch (e) {
            handleError(e, vnode.context, "directive ".concat(dir.name, " ").concat(hook, " hook"));
          }
        }
      }

      var baseModules = [ref, directives$1];

      function updateAttrs(oldVnode, vnode) {
        var opts = vnode.componentOptions;
        if (isDef(opts) && opts.Ctor.options.inheritAttrs === false) {
          return;
        }
        if (isUndef(oldVnode.data.attrs) && isUndef(vnode.data.attrs)) {
          return;
        }
        var key, cur, old;
        var elm = vnode.elm;
        var oldAttrs = oldVnode.data.attrs || {};
        var attrs = vnode.data.attrs || {};
        // clone observed objects, as the user probably wants to mutate it
        if (isDef(attrs.__ob__) || isTrue(attrs._v_attr_proxy)) {
          attrs = vnode.data.attrs = extend({}, attrs);
        }
        for (key in attrs) {
          cur = attrs[key];
          old = oldAttrs[key];
          if (old !== cur) {
            setAttr(elm, key, cur, vnode.data.pre);
          }
        }
        // #4391: in IE9, setting type can reset value for input[type=radio]
        // #6666: IE/Edge forces progress value down to 1 before setting a max
        /* istanbul ignore if */
        if ((isIE || isEdge) && attrs.value !== oldAttrs.value) {
          setAttr(elm, 'value', attrs.value);
        }
        for (key in oldAttrs) {
          if (isUndef(attrs[key])) {
            if (isXlink(key)) {
              elm.removeAttributeNS(xlinkNS, getXlinkProp(key));
            }
            else if (!isEnumeratedAttr(key)) {
              elm.removeAttribute(key);
            }
          }
        }
      }
      function setAttr(el, key, value, isInPre) {
        if (isInPre || el.tagName.indexOf('-') > -1) {
          baseSetAttr(el, key, value);
        }
        else if (isBooleanAttr(key)) {
          // set attribute for blank value
          // e.g. <option disabled>Select one</option>
          if (isFalsyAttrValue(value)) {
            el.removeAttribute(key);
          }
          else {
            // technically allowfullscreen is a boolean attribute for <iframe>,
            // but Flash expects a value of "true" when used on <embed> tag
            value = key === 'allowfullscreen' && el.tagName === 'EMBED' ? 'true' : key;
            el.setAttribute(key, value);
          }
        }
        else if (isEnumeratedAttr(key)) {
          el.setAttribute(key, convertEnumeratedValue(key, value));
        }
        else if (isXlink(key)) {
          if (isFalsyAttrValue(value)) {
            el.removeAttributeNS(xlinkNS, getXlinkProp(key));
          }
          else {
            el.setAttributeNS(xlinkNS, key, value);
          }
        }
        else {
          baseSetAttr(el, key, value);
        }
      }
      function baseSetAttr(el, key, value) {
        if (isFalsyAttrValue(value)) {
          el.removeAttribute(key);
        }
        else {
          // #7138: IE10 & 11 fires input event when setting placeholder on
          // <textarea>... block the first input event and remove the blocker
          // immediately.
          /* istanbul ignore if */
          if (isIE &&
              !isIE9 &&
              el.tagName === 'TEXTAREA' &&
              key === 'placeholder' &&
              value !== '' &&
              !el.__ieph) {
            var blocker_1 = function (e) {
              e.stopImmediatePropagation();
              el.removeEventListener('input', blocker_1);
            };
            el.addEventListener('input', blocker_1);
            // $flow-disable-line
            el.__ieph = true; /* IE placeholder patched */
          }
          el.setAttribute(key, value);
        }
      }
      var attrs = {
        create: updateAttrs,
        update: updateAttrs
      };

      function updateClass(oldVnode, vnode) {
        var el = vnode.elm;
        var data = vnode.data;
        var oldData = oldVnode.data;
        if (isUndef(data.staticClass) &&
            isUndef(data.class) &&
            (isUndef(oldData) ||
                (isUndef(oldData.staticClass) && isUndef(oldData.class)))) {
          return;
        }
        var cls = genClassForVnode(vnode);
        // handle transition classes
        var transitionClass = el._transitionClasses;
        if (isDef(transitionClass)) {
          cls = concat(cls, stringifyClass(transitionClass));
        }
        // set the class
        if (cls !== el._prevClass) {
          el.setAttribute('class', cls);
          el._prevClass = cls;
        }
      }
      var klass$1 = {
        create: updateClass,
        update: updateClass
      };

      var validDivisionCharRE = /[\w).+\-_$\]]/;
      function parseFilters(exp) {
        var inSingle = false;
        var inDouble = false;
        var inTemplateString = false;
        var inRegex = false;
        var curly = 0;
        var square = 0;
        var paren = 0;
        var lastFilterIndex = 0;
        var c, prev, i, expression, filters;
        for (i = 0; i < exp.length; i++) {
          prev = c;
          c = exp.charCodeAt(i);
          if (inSingle) {
            if (c === 0x27 && prev !== 0x5c)
              inSingle = false;
          }
          else if (inDouble) {
            if (c === 0x22 && prev !== 0x5c)
              inDouble = false;
          }
          else if (inTemplateString) {
            if (c === 0x60 && prev !== 0x5c)
              inTemplateString = false;
          }
          else if (inRegex) {
            if (c === 0x2f && prev !== 0x5c)
              inRegex = false;
          }
          else if (c === 0x7c && // pipe
              exp.charCodeAt(i + 1) !== 0x7c &&
              exp.charCodeAt(i - 1) !== 0x7c &&
              !curly &&
              !square &&
              !paren) {
            if (expression === undefined) {
              // first filter, end of expression
              lastFilterIndex = i + 1;
              expression = exp.slice(0, i).trim();
            }
            else {
              pushFilter();
            }
          }
          else {
            switch (c) {
              case 0x22:
                inDouble = true;
                break; // "
              case 0x27:
                inSingle = true;
                break; // '
              case 0x60:
                inTemplateString = true;
                break; // `
              case 0x28:
                paren++;
                break; // (
              case 0x29:
                paren--;
                break; // )
              case 0x5b:
                square++;
                break; // [
              case 0x5d:
                square--;
                break; // ]
              case 0x7b:
                curly++;
                break; // {
              case 0x7d:
                curly--;
                break; // }
            }
            if (c === 0x2f) {
              // /
              var j = i - 1;
              var p
                  // find first non-whitespace prev char
                  = void 0;
              // find first non-whitespace prev char
              for (; j >= 0; j--) {
                p = exp.charAt(j);
                if (p !== ' ')
                  break;
              }
              if (!p || !validDivisionCharRE.test(p)) {
                inRegex = true;
              }
            }
          }
        }
        if (expression === undefined) {
          expression = exp.slice(0, i).trim();
        }
        else if (lastFilterIndex !== 0) {
          pushFilter();
        }
        function pushFilter() {
          (filters || (filters = [])).push(exp.slice(lastFilterIndex, i).trim());
          lastFilterIndex = i + 1;
        }
        if (filters) {
          for (i = 0; i < filters.length; i++) {
            expression = wrapFilter(expression, filters[i]);
          }
        }
        return expression;
      }
      function wrapFilter(exp, filter) {
        var i = filter.indexOf('(');
        if (i < 0) {
          // _f: resolveFilter
          return "_f(\"".concat(filter, "\")(").concat(exp, ")");
        }
        else {
          var name_1 = filter.slice(0, i);
          var args = filter.slice(i + 1);
          return "_f(\"".concat(name_1, "\")(").concat(exp).concat(args !== ')' ? ',' + args : args);
        }
      }

      /* eslint-disable no-unused-vars */
      function baseWarn(msg, range) {
        console.error("[Vue compiler]: ".concat(msg));
      }
      /* eslint-enable no-unused-vars */
      function pluckModuleFunction(modules, key) {
        return modules ? modules.map(function (m) { return m[key]; }).filter(function (_) { return _; }) : [];
      }
      function addProp(el, name, value, range, dynamic) {
        (el.props || (el.props = [])).push(rangeSetItem({ name: name, value: value, dynamic: dynamic }, range));
        el.plain = false;
      }
      function addAttr(el, name, value, range, dynamic) {
        var attrs = dynamic
            ? el.dynamicAttrs || (el.dynamicAttrs = [])
            : el.attrs || (el.attrs = []);
        attrs.push(rangeSetItem({ name: name, value: value, dynamic: dynamic }, range));
        el.plain = false;
      }
// add a raw attr (use this in preTransforms)
      function addRawAttr(el, name, value, range) {
        el.attrsMap[name] = value;
        el.attrsList.push(rangeSetItem({ name: name, value: value }, range));
      }
      function addDirective(el, name, rawName, value, arg, isDynamicArg, modifiers, range) {
        (el.directives || (el.directives = [])).push(rangeSetItem({
          name: name,
          rawName: rawName,
          value: value,
          arg: arg,
          isDynamicArg: isDynamicArg,
          modifiers: modifiers
        }, range));
        el.plain = false;
      }
      function prependModifierMarker(symbol, name, dynamic) {
        return dynamic ? "_p(".concat(name, ",\"").concat(symbol, "\")") : symbol + name; // mark the event as captured
      }
      function addHandler(el, name, value, modifiers, important, warn, range, dynamic) {
        modifiers = modifiers || emptyObject;
        // warn prevent and passive modifier
        /* istanbul ignore if */
        if ( true && warn && modifiers.prevent && modifiers.passive) {
          warn("passive and prevent can't be used together. " +
              "Passive handler can't prevent default event.", range);
        }
        // normalize click.right and click.middle since they don't actually fire
        // this is technically browser-specific, but at least for now browsers are
        // the only target envs that have right/middle clicks.
        if (modifiers.right) {
          if (dynamic) {
            name = "(".concat(name, ")==='click'?'contextmenu':(").concat(name, ")");
          }
          else if (name === 'click') {
            name = 'contextmenu';
            delete modifiers.right;
          }
        }
        else if (modifiers.middle) {
          if (dynamic) {
            name = "(".concat(name, ")==='click'?'mouseup':(").concat(name, ")");
          }
          else if (name === 'click') {
            name = 'mouseup';
          }
        }
        // check capture modifier
        if (modifiers.capture) {
          delete modifiers.capture;
          name = prependModifierMarker('!', name, dynamic);
        }
        if (modifiers.once) {
          delete modifiers.once;
          name = prependModifierMarker('~', name, dynamic);
        }
        /* istanbul ignore if */
        if (modifiers.passive) {
          delete modifiers.passive;
          name = prependModifierMarker('&', name, dynamic);
        }
        var events;
        if (modifiers.native) {
          delete modifiers.native;
          events = el.nativeEvents || (el.nativeEvents = {});
        }
        else {
          events = el.events || (el.events = {});
        }
        var newHandler = rangeSetItem({ value: value.trim(), dynamic: dynamic }, range);
        if (modifiers !== emptyObject) {
          newHandler.modifiers = modifiers;
        }
        var handlers = events[name];
        /* istanbul ignore if */
        if (Array.isArray(handlers)) {
          important ? handlers.unshift(newHandler) : handlers.push(newHandler);
        }
        else if (handlers) {
          events[name] = important ? [newHandler, handlers] : [handlers, newHandler];
        }
        else {
          events[name] = newHandler;
        }
        el.plain = false;
      }
      function getRawBindingAttr(el, name) {
        return (el.rawAttrsMap[':' + name] ||
            el.rawAttrsMap['v-bind:' + name] ||
            el.rawAttrsMap[name]);
      }
      function getBindingAttr(el, name, getStatic) {
        var dynamicValue = getAndRemoveAttr(el, ':' + name) || getAndRemoveAttr(el, 'v-bind:' + name);
        if (dynamicValue != null) {
          return parseFilters(dynamicValue);
        }
        else if (getStatic !== false) {
          var staticValue = getAndRemoveAttr(el, name);
          if (staticValue != null) {
            return JSON.stringify(staticValue);
          }
        }
      }
// note: this only removes the attr from the Array (attrsList) so that it
// doesn't get processed by processAttrs.
// By default it does NOT remove it from the map (attrsMap) because the map is
// needed during codegen.
      function getAndRemoveAttr(el, name, removeFromMap) {
        var val;
        if ((val = el.attrsMap[name]) != null) {
          var list = el.attrsList;
          for (var i = 0, l = list.length; i < l; i++) {
            if (list[i].name === name) {
              list.splice(i, 1);
              break;
            }
          }
        }
        if (removeFromMap) {
          delete el.attrsMap[name];
        }
        return val;
      }
      function getAndRemoveAttrByRegex(el, name) {
        var list = el.attrsList;
        for (var i = 0, l = list.length; i < l; i++) {
          var attr = list[i];
          if (name.test(attr.name)) {
            list.splice(i, 1);
            return attr;
          }
        }
      }
      function rangeSetItem(item, range) {
        if (range) {
          if (range.start != null) {
            item.start = range.start;
          }
          if (range.end != null) {
            item.end = range.end;
          }
        }
        return item;
      }

      /**
       * Cross-platform code generation for component v-model
       */
      function genComponentModel(el, value, modifiers) {
        var _a = modifiers || {}, number = _a.number, trim = _a.trim;
        var baseValueExpression = '$$v';
        var valueExpression = baseValueExpression;
        if (trim) {
          valueExpression =
              "(typeof ".concat(baseValueExpression, " === 'string'") +
              "? ".concat(baseValueExpression, ".trim()") +
              ": ".concat(baseValueExpression, ")");
        }
        if (number) {
          valueExpression = "_n(".concat(valueExpression, ")");
        }
        var assignment = genAssignmentCode(value, valueExpression);
        el.model = {
          value: "(".concat(value, ")"),
          expression: JSON.stringify(value),
          callback: "function (".concat(baseValueExpression, ") {").concat(assignment, "}")
        };
      }
      /**
       * Cross-platform codegen helper for generating v-model value assignment code.
       */
      function genAssignmentCode(value, assignment) {
        var res = parseModel(value);
        if (res.key === null) {
          return "".concat(value, "=").concat(assignment);
        }
        else {
          return "$set(".concat(res.exp, ", ").concat(res.key, ", ").concat(assignment, ")");
        }
      }
      /**
       * Parse a v-model expression into a base path and a final key segment.
       * Handles both dot-path and possible square brackets.
       *
       * Possible cases:
       *
       * - test
       * - test[key]
       * - test[test1[key]]
       * - test["a"][key]
       * - xxx.test[a[a].test1[key]]
       * - test.xxx.a["asa"][test1[key]]
       *
       */
      var len, str, chr, index, expressionPos, expressionEndPos;
      function parseModel(val) {
        // Fix https://github.com/vuejs/vue/pull/7730
        // allow v-model="obj.val " (trailing whitespace)
        val = val.trim();
        len = val.length;
        if (val.indexOf('[') < 0 || val.lastIndexOf(']') < len - 1) {
          index = val.lastIndexOf('.');
          if (index > -1) {
            return {
              exp: val.slice(0, index),
              key: '"' + val.slice(index + 1) + '"'
            };
          }
          else {
            return {
              exp: val,
              key: null
            };
          }
        }
        str = val;
        index = expressionPos = expressionEndPos = 0;
        while (!eof()) {
          chr = next();
          /* istanbul ignore if */
          if (isStringStart(chr)) {
            parseString(chr);
          }
          else if (chr === 0x5b) {
            parseBracket(chr);
          }
        }
        return {
          exp: val.slice(0, expressionPos),
          key: val.slice(expressionPos + 1, expressionEndPos)
        };
      }
      function next() {
        return str.charCodeAt(++index);
      }
      function eof() {
        return index >= len;
      }
      function isStringStart(chr) {
        return chr === 0x22 || chr === 0x27;
      }
      function parseBracket(chr) {
        var inBracket = 1;
        expressionPos = index;
        while (!eof()) {
          chr = next();
          if (isStringStart(chr)) {
            parseString(chr);
            continue;
          }
          if (chr === 0x5b)
            inBracket++;
          if (chr === 0x5d)
            inBracket--;
          if (inBracket === 0) {
            expressionEndPos = index;
            break;
          }
        }
      }
      function parseString(chr) {
        var stringQuote = chr;
        while (!eof()) {
          chr = next();
          if (chr === stringQuote) {
            break;
          }
        }
      }

      var warn$1;
// in some cases, the event used has to be determined at runtime
// so we used some reserved tokens during compile.
      var RANGE_TOKEN = '__r';
      var CHECKBOX_RADIO_TOKEN = '__c';
      function model$1(el, dir, _warn) {
        warn$1 = _warn;
        var value = dir.value;
        var modifiers = dir.modifiers;
        var tag = el.tag;
        var type = el.attrsMap.type;
        if (true) {
          // inputs with type="file" are read only and setting the input's
          // value will throw an error.
          if (tag === 'input' && type === 'file') {
            warn$1("<".concat(el.tag, " v-model=\"").concat(value, "\" type=\"file\">:\n") +
                "File inputs are read only. Use a v-on:change listener instead.", el.rawAttrsMap['v-model']);
          }
        }
        if (el.component) {
          genComponentModel(el, value, modifiers);
          // component v-model doesn't need extra runtime
          return false;
        }
        else if (tag === 'select') {
          genSelect(el, value, modifiers);
        }
        else if (tag === 'input' && type === 'checkbox') {
          genCheckboxModel(el, value, modifiers);
        }
        else if (tag === 'input' && type === 'radio') {
          genRadioModel(el, value, modifiers);
        }
        else if (tag === 'input' || tag === 'textarea') {
          genDefaultModel(el, value, modifiers);
        }
        else if (!config.isReservedTag(tag)) {
          genComponentModel(el, value, modifiers);
          // component v-model doesn't need extra runtime
          return false;
        }
        else if (true) {
          warn$1("<".concat(el.tag, " v-model=\"").concat(value, "\">: ") +
              "v-model is not supported on this element type. " +
              "If you are working with contenteditable, it's recommended to " +
              'wrap a library dedicated for that purpose inside a custom component.', el.rawAttrsMap['v-model']);
        }
        // ensure runtime directive metadata
        return true;
      }
      function genCheckboxModel(el, value, modifiers) {
        var number = modifiers && modifiers.number;
        var valueBinding = getBindingAttr(el, 'value') || 'null';
        var trueValueBinding = getBindingAttr(el, 'true-value') || 'true';
        var falseValueBinding = getBindingAttr(el, 'false-value') || 'false';
        addProp(el, 'checked', "Array.isArray(".concat(value, ")") +
            "?_i(".concat(value, ",").concat(valueBinding, ")>-1") +
            (trueValueBinding === 'true'
                ? ":(".concat(value, ")")
                : ":_q(".concat(value, ",").concat(trueValueBinding, ")")));
        addHandler(el, 'change', "var $$a=".concat(value, ",") +
            '$$el=$event.target,' +
            "$$c=$$el.checked?(".concat(trueValueBinding, "):(").concat(falseValueBinding, ");") +
            'if(Array.isArray($$a)){' +
            "var $$v=".concat(number ? '_n(' + valueBinding + ')' : valueBinding, ",") +
            '$$i=_i($$a,$$v);' +
            "if($$el.checked){$$i<0&&(".concat(genAssignmentCode(value, '$$a.concat([$$v])'), ")}") +
            "else{$$i>-1&&(".concat(genAssignmentCode(value, '$$a.slice(0,$$i).concat($$a.slice($$i+1))'), ")}") +
            "}else{".concat(genAssignmentCode(value, '$$c'), "}"), null, true);
      }
      function genRadioModel(el, value, modifiers) {
        var number = modifiers && modifiers.number;
        var valueBinding = getBindingAttr(el, 'value') || 'null';
        valueBinding = number ? "_n(".concat(valueBinding, ")") : valueBinding;
        addProp(el, 'checked', "_q(".concat(value, ",").concat(valueBinding, ")"));
        addHandler(el, 'change', genAssignmentCode(value, valueBinding), null, true);
      }
      function genSelect(el, value, modifiers) {
        var number = modifiers && modifiers.number;
        var selectedVal = "Array.prototype.filter" +
            ".call($event.target.options,function(o){return o.selected})" +
            ".map(function(o){var val = \"_value\" in o ? o._value : o.value;" +
            "return ".concat(number ? '_n(val)' : 'val', "})");
        var assignment = '$event.target.multiple ? $$selectedVal : $$selectedVal[0]';
        var code = "var $$selectedVal = ".concat(selectedVal, ";");
        code = "".concat(code, " ").concat(genAssignmentCode(value, assignment));
        addHandler(el, 'change', code, null, true);
      }
      function genDefaultModel(el, value, modifiers) {
        var type = el.attrsMap.type;
        // warn if v-bind:value conflicts with v-model
        // except for inputs with v-bind:type
        if (true) {
          var value_1 = el.attrsMap['v-bind:value'] || el.attrsMap[':value'];
          var typeBinding = el.attrsMap['v-bind:type'] || el.attrsMap[':type'];
          if (value_1 && !typeBinding) {
            var binding = el.attrsMap['v-bind:value'] ? 'v-bind:value' : ':value';
            warn$1("".concat(binding, "=\"").concat(value_1, "\" conflicts with v-model on the same element ") +
                'because the latter already expands to a value binding internally', el.rawAttrsMap[binding]);
          }
        }
        var _a = modifiers || {}, lazy = _a.lazy, number = _a.number, trim = _a.trim;
        var needCompositionGuard = !lazy && type !== 'range';
        var event = lazy ? 'change' : type === 'range' ? RANGE_TOKEN : 'input';
        var valueExpression = '$event.target.value';
        if (trim) {
          valueExpression = "$event.target.value.trim()";
        }
        if (number) {
          valueExpression = "_n(".concat(valueExpression, ")");
        }
        var code = genAssignmentCode(value, valueExpression);
        if (needCompositionGuard) {
          code = "if($event.target.composing)return;".concat(code);
        }
        addProp(el, 'value', "(".concat(value, ")"));
        addHandler(el, event, code, null, true);
        if (trim || number) {
          addHandler(el, 'blur', '$forceUpdate()');
        }
      }

// normalize v-model event tokens that can only be determined at runtime.
// it's important to place the event as the first in the array because
// the whole point is ensuring the v-model callback gets called before
// user-attached handlers.
      function normalizeEvents(on) {
        /* istanbul ignore if */
        if (isDef(on[RANGE_TOKEN])) {
          // IE input[type=range] only supports `change` event
          var event_1 = isIE ? 'change' : 'input';
          on[event_1] = [].concat(on[RANGE_TOKEN], on[event_1] || []);
          delete on[RANGE_TOKEN];
        }
        // This was originally intended to fix #4521 but no longer necessary
        // after 2.5. Keeping it for backwards compat with generated code from < 2.4
        /* istanbul ignore if */
        if (isDef(on[CHECKBOX_RADIO_TOKEN])) {
          on.change = [].concat(on[CHECKBOX_RADIO_TOKEN], on.change || []);
          delete on[CHECKBOX_RADIO_TOKEN];
        }
      }
      var target;
      function createOnceHandler(event, handler, capture) {
        var _target = target; // save current target element in closure
        return function onceHandler() {
          var res = handler.apply(null, arguments);
          if (res !== null) {
            remove(event, onceHandler, capture, _target);
          }
        };
      }
// #9446: Firefox <= 53 (in particular, ESR 52) has incorrect Event.timeStamp
// implementation and does not fire microtasks in between event propagation, so
// safe to exclude.
      var useMicrotaskFix = isUsingMicroTask && !(isFF && Number(isFF[1]) <= 53);
      function add(name, handler, capture, passive) {
        // async edge case #6566: inner click event triggers patch, event handler
        // attached to outer element during patch, and triggered again. This
        // happens because browsers fire microtask ticks between event propagation.
        // the solution is simple: we save the timestamp when a handler is attached,
        // and the handler would only fire if the event passed to it was fired
        // AFTER it was attached.
        if (useMicrotaskFix) {
          var attachedTimestamp_1 = currentFlushTimestamp;
          var original_1 = handler;
          //@ts-expect-error
          handler = original_1._wrapper = function (e) {
            if (
                // no bubbling, should always fire.
                // this is just a safety net in case event.timeStamp is unreliable in
                // certain weird environments...
                e.target === e.currentTarget ||
                // event is fired after handler attachment
                e.timeStamp >= attachedTimestamp_1 ||
                // bail for environments that have buggy event.timeStamp implementations
                // #9462 iOS 9 bug: event.timeStamp is 0 after history.pushState
                // #9681 QtWebEngine event.timeStamp is negative value
                e.timeStamp <= 0 ||
                // #9448 bail if event is fired in another document in a multi-page
                // electron/nw.js app, since event.timeStamp will be using a different
                // starting reference
                e.target.ownerDocument !== document) {
              return original_1.apply(this, arguments);
            }
          };
        }
        target.addEventListener(name, handler, supportsPassive ? { capture: capture, passive: passive } : capture);
      }
      function remove(name, handler, capture, _target) {
        (_target || target).removeEventListener(name,
            //@ts-expect-error
            handler._wrapper || handler, capture);
      }
      function updateDOMListeners(oldVnode, vnode) {
        if (isUndef(oldVnode.data.on) && isUndef(vnode.data.on)) {
          return;
        }
        var on = vnode.data.on || {};
        var oldOn = oldVnode.data.on || {};
        // vnode is empty when removing all listeners,
        // and use old vnode dom element
        target = vnode.elm || oldVnode.elm;
        normalizeEvents(on);
        updateListeners(on, oldOn, add, remove, createOnceHandler, vnode.context);
        target = undefined;
      }
      var events = {
        create: updateDOMListeners,
        update: updateDOMListeners,
        // @ts-expect-error emptyNode has actually data
        destroy: function (vnode) { return updateDOMListeners(vnode, emptyNode); }
      };

      var svgContainer;
      function updateDOMProps(oldVnode, vnode) {
        if (isUndef(oldVnode.data.domProps) && isUndef(vnode.data.domProps)) {
          return;
        }
        var key, cur;
        var elm = vnode.elm;
        var oldProps = oldVnode.data.domProps || {};
        var props = vnode.data.domProps || {};
        // clone observed objects, as the user probably wants to mutate it
        if (isDef(props.__ob__) || isTrue(props._v_attr_proxy)) {
          props = vnode.data.domProps = extend({}, props);
        }
        for (key in oldProps) {
          if (!(key in props)) {
            elm[key] = '';
          }
        }
        for (key in props) {
          cur = props[key];
          // ignore children if the node has textContent or innerHTML,
          // as these will throw away existing DOM nodes and cause removal errors
          // on subsequent patches (#3360)
          if (key === 'textContent' || key === 'innerHTML') {
            if (vnode.children)
              vnode.children.length = 0;
            if (cur === oldProps[key])
              continue;
            // #6601 work around Chrome version <= 55 bug where single textNode
            // replaced by innerHTML/textContent retains its parentNode property
            if (elm.childNodes.length === 1) {
              elm.removeChild(elm.childNodes[0]);
            }
          }
          if (key === 'value' && elm.tagName !== 'PROGRESS') {
            // store value as _value as well since
            // non-string values will be stringified
            elm._value = cur;
            // avoid resetting cursor position when value is the same
            var strCur = isUndef(cur) ? '' : String(cur);
            if (shouldUpdateValue(elm, strCur)) {
              elm.value = strCur;
            }
          }
          else if (key === 'innerHTML' &&
              isSVG(elm.tagName) &&
              isUndef(elm.innerHTML)) {
            // IE doesn't support innerHTML for SVG elements
            svgContainer = svgContainer || document.createElement('div');
            svgContainer.innerHTML = "<svg>".concat(cur, "</svg>");
            var svg = svgContainer.firstChild;
            while (elm.firstChild) {
              elm.removeChild(elm.firstChild);
            }
            while (svg.firstChild) {
              elm.appendChild(svg.firstChild);
            }
          }
          else if (
              // skip the update if old and new VDOM state is the same.
              // `value` is handled separately because the DOM value may be temporarily
              // out of sync with VDOM state due to focus, composition and modifiers.
              // This  #4521 by skipping the unnecessary `checked` update.
              cur !== oldProps[key]) {
            // some property updates can throw
            // e.g. `value` on <progress> w/ non-finite value
            try {
              elm[key] = cur;
            }
            catch (e) { }
          }
        }
      }
      function shouldUpdateValue(elm, checkVal) {
        return (
            //@ts-expect-error
            !elm.composing &&
            (elm.tagName === 'OPTION' ||
                isNotInFocusAndDirty(elm, checkVal) ||
                isDirtyWithModifiers(elm, checkVal)));
      }
      function isNotInFocusAndDirty(elm, checkVal) {
        // return true when textbox (.number and .trim) loses focus and its value is
        // not equal to the updated value
        var notInFocus = true;
        // #6157
        // work around IE bug when accessing document.activeElement in an iframe
        try {
          notInFocus = document.activeElement !== elm;
        }
        catch (e) { }
        return notInFocus && elm.value !== checkVal;
      }
      function isDirtyWithModifiers(elm, newVal) {
        var value = elm.value;
        var modifiers = elm._vModifiers; // injected by v-model runtime
        if (isDef(modifiers)) {
          if (modifiers.number) {
            return toNumber(value) !== toNumber(newVal);
          }
          if (modifiers.trim) {
            return value.trim() !== newVal.trim();
          }
        }
        return value !== newVal;
      }
      var domProps = {
        create: updateDOMProps,
        update: updateDOMProps
      };

      var parseStyleText = cached(function (cssText) {
        var res = {};
        var listDelimiter = /;(?![^(]*\))/g;
        var propertyDelimiter = /:(.+)/;
        cssText.split(listDelimiter).forEach(function (item) {
          if (item) {
            var tmp = item.split(propertyDelimiter);
            tmp.length > 1 && (res[tmp[0].trim()] = tmp[1].trim());
          }
        });
        return res;
      });
// merge static and dynamic style data on the same vnode
      function normalizeStyleData(data) {
        var style = normalizeStyleBinding(data.style);
        // static style is pre-processed into an object during compilation
        // and is always a fresh object, so it's safe to merge into it
        return data.staticStyle ? extend(data.staticStyle, style) : style;
      }
// normalize possible array / string values into Object
      function normalizeStyleBinding(bindingStyle) {
        if (Array.isArray(bindingStyle)) {
          return toObject(bindingStyle);
        }
        if (typeof bindingStyle === 'string') {
          return parseStyleText(bindingStyle);
        }
        return bindingStyle;
      }
      /**
       * parent component style should be after child's
       * so that parent component's style could override it
       */
      function getStyle(vnode, checkChild) {
        var res = {};
        var styleData;
        if (checkChild) {
          var childNode = vnode;
          while (childNode.componentInstance) {
            childNode = childNode.componentInstance._vnode;
            if (childNode &&
                childNode.data &&
                (styleData = normalizeStyleData(childNode.data))) {
              extend(res, styleData);
            }
          }
        }
        if ((styleData = normalizeStyleData(vnode.data))) {
          extend(res, styleData);
        }
        var parentNode = vnode;
        // @ts-expect-error parentNode.parent not VNodeWithData
        while ((parentNode = parentNode.parent)) {
          if (parentNode.data && (styleData = normalizeStyleData(parentNode.data))) {
            extend(res, styleData);
          }
        }
        return res;
      }

      var cssVarRE = /^--/;
      var importantRE = /\s*!important$/;
      var setProp = function (el, name, val) {
        /* istanbul ignore if */
        if (cssVarRE.test(name)) {
          el.style.setProperty(name, val);
        }
        else if (importantRE.test(val)) {
          el.style.setProperty(hyphenate(name), val.replace(importantRE, ''), 'important');
        }
        else {
          var normalizedName = normalize(name);
          if (Array.isArray(val)) {
            // Support values array created by autoprefixer, e.g.
            // {display: ["-webkit-box", "-ms-flexbox", "flex"]}
            // Set them one by one, and the browser will only set those it can recognize
            for (var i = 0, len = val.length; i < len; i++) {
              el.style[normalizedName] = val[i];
            }
          }
          else {
            el.style[normalizedName] = val;
          }
        }
      };
      var vendorNames = ['Webkit', 'Moz', 'ms'];
      var emptyStyle;
      var normalize = cached(function (prop) {
        emptyStyle = emptyStyle || document.createElement('div').style;
        prop = camelize(prop);
        if (prop !== 'filter' && prop in emptyStyle) {
          return prop;
        }
        var capName = prop.charAt(0).toUpperCase() + prop.slice(1);
        for (var i = 0; i < vendorNames.length; i++) {
          var name_1 = vendorNames[i] + capName;
          if (name_1 in emptyStyle) {
            return name_1;
          }
        }
      });
      function updateStyle(oldVnode, vnode) {
        var data = vnode.data;
        var oldData = oldVnode.data;
        if (isUndef(data.staticStyle) &&
            isUndef(data.style) &&
            isUndef(oldData.staticStyle) &&
            isUndef(oldData.style)) {
          return;
        }
        var cur, name;
        var el = vnode.elm;
        var oldStaticStyle = oldData.staticStyle;
        var oldStyleBinding = oldData.normalizedStyle || oldData.style || {};
        // if static style exists, stylebinding already merged into it when doing normalizeStyleData
        var oldStyle = oldStaticStyle || oldStyleBinding;
        var style = normalizeStyleBinding(vnode.data.style) || {};
        // store normalized style under a different key for next diff
        // make sure to clone it if it's reactive, since the user likely wants
        // to mutate it.
        vnode.data.normalizedStyle = isDef(style.__ob__) ? extend({}, style) : style;
        var newStyle = getStyle(vnode, true);
        for (name in oldStyle) {
          if (isUndef(newStyle[name])) {
            setProp(el, name, '');
          }
        }
        for (name in newStyle) {
          cur = newStyle[name];
          if (cur !== oldStyle[name]) {
            // ie9 setting to null has no effect, must use empty string
            setProp(el, name, cur == null ? '' : cur);
          }
        }
      }
      var style$1 = {
        create: updateStyle,
        update: updateStyle
      };

      var whitespaceRE$1 = /\s+/;
      /**
       * Add class with compatibility for SVG since classList is not supported on
       * SVG elements in IE
       */
      function addClass(el, cls) {
        /* istanbul ignore if */
        if (!cls || !(cls = cls.trim())) {
          return;
        }
        /* istanbul ignore else */
        if (el.classList) {
          if (cls.indexOf(' ') > -1) {
            cls.split(whitespaceRE$1).forEach(function (c) { return el.classList.add(c); });
          }
          else {
            el.classList.add(cls);
          }
        }
        else {
          var cur = " ".concat(el.getAttribute('class') || '', " ");
          if (cur.indexOf(' ' + cls + ' ') < 0) {
            el.setAttribute('class', (cur + cls).trim());
          }
        }
      }
      /**
       * Remove class with compatibility for SVG since classList is not supported on
       * SVG elements in IE
       */
      function removeClass(el, cls) {
        /* istanbul ignore if */
        if (!cls || !(cls = cls.trim())) {
          return;
        }
        /* istanbul ignore else */
        if (el.classList) {
          if (cls.indexOf(' ') > -1) {
            cls.split(whitespaceRE$1).forEach(function (c) { return el.classList.remove(c); });
          }
          else {
            el.classList.remove(cls);
          }
          if (!el.classList.length) {
            el.removeAttribute('class');
          }
        }
        else {
          var cur = " ".concat(el.getAttribute('class') || '', " ");
          var tar = ' ' + cls + ' ';
          while (cur.indexOf(tar) >= 0) {
            cur = cur.replace(tar, ' ');
          }
          cur = cur.trim();
          if (cur) {
            el.setAttribute('class', cur);
          }
          else {
            el.removeAttribute('class');
          }
        }
      }

      function resolveTransition(def) {
        if (!def) {
          return;
        }
        /* istanbul ignore else */
        if (typeof def === 'object') {
          var res = {};
          if (def.css !== false) {
            extend(res, autoCssTransition(def.name || 'v'));
          }
          extend(res, def);
          return res;
        }
        else if (typeof def === 'string') {
          return autoCssTransition(def);
        }
      }
      var autoCssTransition = cached(function (name) {
        return {
          enterClass: "".concat(name, "-enter"),
          enterToClass: "".concat(name, "-enter-to"),
          enterActiveClass: "".concat(name, "-enter-active"),
          leaveClass: "".concat(name, "-leave"),
          leaveToClass: "".concat(name, "-leave-to"),
          leaveActiveClass: "".concat(name, "-leave-active")
        };
      });
      var hasTransition = inBrowser && !isIE9;
      var TRANSITION = 'transition';
      var ANIMATION = 'animation';
// Transition property/event sniffing
      var transitionProp = 'transition';
      var transitionEndEvent = 'transitionend';
      var animationProp = 'animation';
      var animationEndEvent = 'animationend';
      if (hasTransition) {
        /* istanbul ignore if */
        if (window.ontransitionend === undefined &&
            window.onwebkittransitionend !== undefined) {
          transitionProp = 'WebkitTransition';
          transitionEndEvent = 'webkitTransitionEnd';
        }
        if (window.onanimationend === undefined &&
            window.onwebkitanimationend !== undefined) {
          animationProp = 'WebkitAnimation';
          animationEndEvent = 'webkitAnimationEnd';
        }
      }
// binding to window is necessary to make hot reload work in IE in strict mode
      var raf = inBrowser
          ? window.requestAnimationFrame
              ? window.requestAnimationFrame.bind(window)
              : setTimeout
          : /* istanbul ignore next */ function (/* istanbul ignore next */ fn) { return fn(); };
      function nextFrame(fn) {
        raf(function () {
          // @ts-expect-error
          raf(fn);
        });
      }
      function addTransitionClass(el, cls) {
        var transitionClasses = el._transitionClasses || (el._transitionClasses = []);
        if (transitionClasses.indexOf(cls) < 0) {
          transitionClasses.push(cls);
          addClass(el, cls);
        }
      }
      function removeTransitionClass(el, cls) {
        if (el._transitionClasses) {
          remove$2(el._transitionClasses, cls);
        }
        removeClass(el, cls);
      }
      function whenTransitionEnds(el, expectedType, cb) {
        var _a = getTransitionInfo(el, expectedType), type = _a.type, timeout = _a.timeout, propCount = _a.propCount;
        if (!type)
          return cb();
        var event = type === TRANSITION ? transitionEndEvent : animationEndEvent;
        var ended = 0;
        var end = function () {
          el.removeEventListener(event, onEnd);
          cb();
        };
        var onEnd = function (e) {
          if (e.target === el) {
            if (++ended >= propCount) {
              end();
            }
          }
        };
        setTimeout(function () {
          if (ended < propCount) {
            end();
          }
        }, timeout + 1);
        el.addEventListener(event, onEnd);
      }
      var transformRE = /\b(transform|all)(,|$)/;
      function getTransitionInfo(el, expectedType) {
        var styles = window.getComputedStyle(el);
        // JSDOM may return undefined for transition properties
        var transitionDelays = (styles[transitionProp + 'Delay'] || '').split(', ');
        var transitionDurations = (styles[transitionProp + 'Duration'] || '').split(', ');
        var transitionTimeout = getTimeout(transitionDelays, transitionDurations);
        var animationDelays = (styles[animationProp + 'Delay'] || '').split(', ');
        var animationDurations = (styles[animationProp + 'Duration'] || '').split(', ');
        var animationTimeout = getTimeout(animationDelays, animationDurations);
        var type;
        var timeout = 0;
        var propCount = 0;
        /* istanbul ignore if */
        if (expectedType === TRANSITION) {
          if (transitionTimeout > 0) {
            type = TRANSITION;
            timeout = transitionTimeout;
            propCount = transitionDurations.length;
          }
        }
        else if (expectedType === ANIMATION) {
          if (animationTimeout > 0) {
            type = ANIMATION;
            timeout = animationTimeout;
            propCount = animationDurations.length;
          }
        }
        else {
          timeout = Math.max(transitionTimeout, animationTimeout);
          type =
              timeout > 0
                  ? transitionTimeout > animationTimeout
                  ? TRANSITION
                  : ANIMATION
                  : null;
          propCount = type
              ? type === TRANSITION
                  ? transitionDurations.length
                  : animationDurations.length
              : 0;
        }
        var hasTransform = type === TRANSITION && transformRE.test(styles[transitionProp + 'Property']);
        return {
          type: type,
          timeout: timeout,
          propCount: propCount,
          hasTransform: hasTransform
        };
      }
      function getTimeout(delays, durations) {
        /* istanbul ignore next */
        while (delays.length < durations.length) {
          delays = delays.concat(delays);
        }
        return Math.max.apply(null, durations.map(function (d, i) {
          return toMs(d) + toMs(delays[i]);
        }));
      }
// Old versions of Chromium (below 61.0.3163.100) formats floating pointer numbers
// in a locale-dependent way, using a comma instead of a dot.
// If comma is not replaced with a dot, the input will be rounded down (i.e. acting
// as a floor function) causing unexpected behaviors
      function toMs(s) {
        return Number(s.slice(0, -1).replace(',', '.')) * 1000;
      }

      function enter(vnode, toggleDisplay) {
        var el = vnode.elm;
        // call leave callback now
        if (isDef(el._leaveCb)) {
          el._leaveCb.cancelled = true;
          el._leaveCb();
        }
        var data = resolveTransition(vnode.data.transition);
        if (isUndef(data)) {
          return;
        }
        /* istanbul ignore if */
        if (isDef(el._enterCb) || el.nodeType !== 1) {
          return;
        }
        var css = data.css, type = data.type, enterClass = data.enterClass, enterToClass = data.enterToClass, enterActiveClass = data.enterActiveClass, appearClass = data.appearClass, appearToClass = data.appearToClass, appearActiveClass = data.appearActiveClass, beforeEnter = data.beforeEnter, enter = data.enter, afterEnter = data.afterEnter, enterCancelled = data.enterCancelled, beforeAppear = data.beforeAppear, appear = data.appear, afterAppear = data.afterAppear, appearCancelled = data.appearCancelled, duration = data.duration;
        // activeInstance will always be the <transition> component managing this
        // transition. One edge case to check is when the <transition> is placed
        // as the root node of a child component. In that case we need to check
        // <transition>'s parent for appear check.
        var context = activeInstance;
        var transitionNode = activeInstance.$vnode;
        while (transitionNode && transitionNode.parent) {
          context = transitionNode.context;
          transitionNode = transitionNode.parent;
        }
        var isAppear = !context._isMounted || !vnode.isRootInsert;
        if (isAppear && !appear && appear !== '') {
          return;
        }
        var startClass = isAppear && appearClass ? appearClass : enterClass;
        var activeClass = isAppear && appearActiveClass ? appearActiveClass : enterActiveClass;
        var toClass = isAppear && appearToClass ? appearToClass : enterToClass;
        var beforeEnterHook = isAppear ? beforeAppear || beforeEnter : beforeEnter;
        var enterHook = isAppear ? (isFunction(appear) ? appear : enter) : enter;
        var afterEnterHook = isAppear ? afterAppear || afterEnter : afterEnter;
        var enterCancelledHook = isAppear
            ? appearCancelled || enterCancelled
            : enterCancelled;
        var explicitEnterDuration = toNumber(isObject(duration) ? duration.enter : duration);
        if ( true && explicitEnterDuration != null) {
          checkDuration(explicitEnterDuration, 'enter', vnode);
        }
        var expectsCSS = css !== false && !isIE9;
        var userWantsControl = getHookArgumentsLength(enterHook);
        var cb = (el._enterCb = once(function () {
          if (expectsCSS) {
            removeTransitionClass(el, toClass);
            removeTransitionClass(el, activeClass);
          }
          // @ts-expect-error
          if (cb.cancelled) {
            if (expectsCSS) {
              removeTransitionClass(el, startClass);
            }
            enterCancelledHook && enterCancelledHook(el);
          }
          else {
            afterEnterHook && afterEnterHook(el);
          }
          el._enterCb = null;
        }));
        if (!vnode.data.show) {
          // remove pending leave element on enter by injecting an insert hook
          mergeVNodeHook(vnode, 'insert', function () {
            var parent = el.parentNode;
            var pendingNode = parent && parent._pending && parent._pending[vnode.key];
            if (pendingNode &&
                pendingNode.tag === vnode.tag &&
                pendingNode.elm._leaveCb) {
              pendingNode.elm._leaveCb();
            }
            enterHook && enterHook(el, cb);
          });
        }
        // start enter transition
        beforeEnterHook && beforeEnterHook(el);
        if (expectsCSS) {
          addTransitionClass(el, startClass);
          addTransitionClass(el, activeClass);
          nextFrame(function () {
            removeTransitionClass(el, startClass);
            // @ts-expect-error
            if (!cb.cancelled) {
              addTransitionClass(el, toClass);
              if (!userWantsControl) {
                if (isValidDuration(explicitEnterDuration)) {
                  setTimeout(cb, explicitEnterDuration);
                }
                else {
                  whenTransitionEnds(el, type, cb);
                }
              }
            }
          });
        }
        if (vnode.data.show) {
          toggleDisplay && toggleDisplay();
          enterHook && enterHook(el, cb);
        }
        if (!expectsCSS && !userWantsControl) {
          cb();
        }
      }
      function leave(vnode, rm) {
        var el = vnode.elm;
        // call enter callback now
        if (isDef(el._enterCb)) {
          el._enterCb.cancelled = true;
          el._enterCb();
        }
        var data = resolveTransition(vnode.data.transition);
        if (isUndef(data) || el.nodeType !== 1) {
          return rm();
        }
        /* istanbul ignore if */
        if (isDef(el._leaveCb)) {
          return;
        }
        var css = data.css, type = data.type, leaveClass = data.leaveClass, leaveToClass = data.leaveToClass, leaveActiveClass = data.leaveActiveClass, beforeLeave = data.beforeLeave, leave = data.leave, afterLeave = data.afterLeave, leaveCancelled = data.leaveCancelled, delayLeave = data.delayLeave, duration = data.duration;
        var expectsCSS = css !== false && !isIE9;
        var userWantsControl = getHookArgumentsLength(leave);
        var explicitLeaveDuration = toNumber(isObject(duration) ? duration.leave : duration);
        if ( true && isDef(explicitLeaveDuration)) {
          checkDuration(explicitLeaveDuration, 'leave', vnode);
        }
        var cb = (el._leaveCb = once(function () {
          if (el.parentNode && el.parentNode._pending) {
            el.parentNode._pending[vnode.key] = null;
          }
          if (expectsCSS) {
            removeTransitionClass(el, leaveToClass);
            removeTransitionClass(el, leaveActiveClass);
          }
          // @ts-expect-error
          if (cb.cancelled) {
            if (expectsCSS) {
              removeTransitionClass(el, leaveClass);
            }
            leaveCancelled && leaveCancelled(el);
          }
          else {
            rm();
            afterLeave && afterLeave(el);
          }
          el._leaveCb = null;
        }));
        if (delayLeave) {
          delayLeave(performLeave);
        }
        else {
          performLeave();
        }
        function performLeave() {
          // the delayed leave may have already been cancelled
          // @ts-expect-error
          if (cb.cancelled) {
            return;
          }
          // record leaving element
          if (!vnode.data.show && el.parentNode) {
            (el.parentNode._pending || (el.parentNode._pending = {}))[vnode.key] =
                vnode;
          }
          beforeLeave && beforeLeave(el);
          if (expectsCSS) {
            addTransitionClass(el, leaveClass);
            addTransitionClass(el, leaveActiveClass);
            nextFrame(function () {
              removeTransitionClass(el, leaveClass);
              // @ts-expect-error
              if (!cb.cancelled) {
                addTransitionClass(el, leaveToClass);
                if (!userWantsControl) {
                  if (isValidDuration(explicitLeaveDuration)) {
                    setTimeout(cb, explicitLeaveDuration);
                  }
                  else {
                    whenTransitionEnds(el, type, cb);
                  }
                }
              }
            });
          }
          leave && leave(el, cb);
          if (!expectsCSS && !userWantsControl) {
            cb();
          }
        }
      }
// only used in dev mode
      function checkDuration(val, name, vnode) {
        if (typeof val !== 'number') {
          warn$2("<transition> explicit ".concat(name, " duration is not a valid number - ") +
              "got ".concat(JSON.stringify(val), "."), vnode.context);
        }
        else if (isNaN(val)) {
          warn$2("<transition> explicit ".concat(name, " duration is NaN - ") +
              'the duration expression might be incorrect.', vnode.context);
        }
      }
      function isValidDuration(val) {
        return typeof val === 'number' && !isNaN(val);
      }
      /**
       * Normalize a transition hook's argument length. The hook may be:
       * - a merged hook (invoker) with the original in .fns
       * - a wrapped component method (check ._length)
       * - a plain function (.length)
       */
      function getHookArgumentsLength(fn) {
        if (isUndef(fn)) {
          return false;
        }
        // @ts-expect-error
        var invokerFns = fn.fns;
        if (isDef(invokerFns)) {
          // invoker
          return getHookArgumentsLength(Array.isArray(invokerFns) ? invokerFns[0] : invokerFns);
        }
        else {
          // @ts-expect-error
          return (fn._length || fn.length) > 1;
        }
      }
      function _enter(_, vnode) {
        if (vnode.data.show !== true) {
          enter(vnode);
        }
      }
      var transition = inBrowser
          ? {
            create: _enter,
            activate: _enter,
            remove: function (vnode, rm) {
              /* istanbul ignore else */
              if (vnode.data.show !== true) {
                // @ts-expect-error
                leave(vnode, rm);
              }
              else {
                rm();
              }
            }
          }
          : {};

      var platformModules = [attrs, klass$1, events, domProps, style$1, transition];

// the directive module should be applied last, after all
// built-in modules have been applied.
      var modules$1 = platformModules.concat(baseModules);
      var patch = createPatchFunction({ nodeOps: nodeOps, modules: modules$1 });

      /**
       * Not type checking this file because flow doesn't like attaching
       * properties to Elements.
       */
      /* istanbul ignore if */
      if (isIE9) {
        // http://www.matts411.com/post/internet-explorer-9-oninput/
        document.addEventListener('selectionchange', function () {
          var el = document.activeElement;
          // @ts-expect-error
          if (el && el.vmodel) {
            trigger(el, 'input');
          }
        });
      }
      var directive = {
        inserted: function (el, binding, vnode, oldVnode) {
          if (vnode.tag === 'select') {
            // #6903
            if (oldVnode.elm && !oldVnode.elm._vOptions) {
              mergeVNodeHook(vnode, 'postpatch', function () {
                directive.componentUpdated(el, binding, vnode);
              });
            }
            else {
              setSelected(el, binding, vnode.context);
            }
            el._vOptions = [].map.call(el.options, getValue);
          }
          else if (vnode.tag === 'textarea' || isTextInputType(el.type)) {
            el._vModifiers = binding.modifiers;
            if (!binding.modifiers.lazy) {
              el.addEventListener('compositionstart', onCompositionStart);
              el.addEventListener('compositionend', onCompositionEnd);
              // Safari < 10.2 & UIWebView doesn't fire compositionend when
              // switching focus before confirming composition choice
              // this also fixes the issue where some browsers e.g. iOS Chrome
              // fires "change" instead of "input" on autocomplete.
              el.addEventListener('change', onCompositionEnd);
              /* istanbul ignore if */
              if (isIE9) {
                el.vmodel = true;
              }
            }
          }
        },
        componentUpdated: function (el, binding, vnode) {
          if (vnode.tag === 'select') {
            setSelected(el, binding, vnode.context);
            // in case the options rendered by v-for have changed,
            // it's possible that the value is out-of-sync with the rendered options.
            // detect such cases and filter out values that no longer has a matching
            // option in the DOM.
            var prevOptions_1 = el._vOptions;
            var curOptions_1 = (el._vOptions = [].map.call(el.options, getValue));
            if (curOptions_1.some(function (o, i) { return !looseEqual(o, prevOptions_1[i]); })) {
              // trigger change event if
              // no matching option found for at least one value
              var needReset = el.multiple
                  ? binding.value.some(function (v) { return hasNoMatchingOption(v, curOptions_1); })
                  : binding.value !== binding.oldValue &&
                  hasNoMatchingOption(binding.value, curOptions_1);
              if (needReset) {
                trigger(el, 'change');
              }
            }
          }
        }
      };
      function setSelected(el, binding, vm) {
        actuallySetSelected(el, binding, vm);
        /* istanbul ignore if */
        if (isIE || isEdge) {
          setTimeout(function () {
            actuallySetSelected(el, binding, vm);
          }, 0);
        }
      }
      function actuallySetSelected(el, binding, vm) {
        var value = binding.value;
        var isMultiple = el.multiple;
        if (isMultiple && !Array.isArray(value)) {
          true &&
          warn$2("<select multiple v-model=\"".concat(binding.expression, "\"> ") +
              "expects an Array value for its binding, but got ".concat(Object.prototype.toString
                  .call(value)
                  .slice(8, -1)), vm);
          return;
        }
        var selected, option;
        for (var i = 0, l = el.options.length; i < l; i++) {
          option = el.options[i];
          if (isMultiple) {
            selected = looseIndexOf(value, getValue(option)) > -1;
            if (option.selected !== selected) {
              option.selected = selected;
            }
          }
          else {
            if (looseEqual(getValue(option), value)) {
              if (el.selectedIndex !== i) {
                el.selectedIndex = i;
              }
              return;
            }
          }
        }
        if (!isMultiple) {
          el.selectedIndex = -1;
        }
      }
      function hasNoMatchingOption(value, options) {
        return options.every(function (o) { return !looseEqual(o, value); });
      }
      function getValue(option) {
        return '_value' in option ? option._value : option.value;
      }
      function onCompositionStart(e) {
        e.target.composing = true;
      }
      function onCompositionEnd(e) {
        // prevent triggering an input event for no reason
        if (!e.target.composing)
          return;
        e.target.composing = false;
        trigger(e.target, 'input');
      }
      function trigger(el, type) {
        var e = document.createEvent('HTMLEvents');
        e.initEvent(type, true, true);
        el.dispatchEvent(e);
      }

// recursively search for possible transition defined inside the component root
      function locateNode(vnode) {
        // @ts-expect-error
        return vnode.componentInstance && (!vnode.data || !vnode.data.transition)
            ? locateNode(vnode.componentInstance._vnode)
            : vnode;
      }
      var show = {
        bind: function (el, _a, vnode) {
          var value = _a.value;
          vnode = locateNode(vnode);
          var transition = vnode.data && vnode.data.transition;
          var originalDisplay = (el.__vOriginalDisplay =
              el.style.display === 'none' ? '' : el.style.display);
          if (value && transition) {
            vnode.data.show = true;
            enter(vnode, function () {
              el.style.display = originalDisplay;
            });
          }
          else {
            el.style.display = value ? originalDisplay : 'none';
          }
        },
        update: function (el, _a, vnode) {
          var value = _a.value, oldValue = _a.oldValue;
          /* istanbul ignore if */
          if (!value === !oldValue)
            return;
          vnode = locateNode(vnode);
          var transition = vnode.data && vnode.data.transition;
          if (transition) {
            vnode.data.show = true;
            if (value) {
              enter(vnode, function () {
                el.style.display = el.__vOriginalDisplay;
              });
            }
            else {
              leave(vnode, function () {
                el.style.display = 'none';
              });
            }
          }
          else {
            el.style.display = value ? el.__vOriginalDisplay : 'none';
          }
        },
        unbind: function (el, binding, vnode, oldVnode, isDestroy) {
          if (!isDestroy) {
            el.style.display = el.__vOriginalDisplay;
          }
        }
      };

      var platformDirectives = {
        model: directive,
        show: show
      };

// Provides transition support for a single element/component.
      var transitionProps = {
        name: String,
        appear: Boolean,
        css: Boolean,
        mode: String,
        type: String,
        enterClass: String,
        leaveClass: String,
        enterToClass: String,
        leaveToClass: String,
        enterActiveClass: String,
        leaveActiveClass: String,
        appearClass: String,
        appearActiveClass: String,
        appearToClass: String,
        duration: [Number, String, Object]
      };
// in case the child is also an abstract component, e.g. <keep-alive>
// we want to recursively retrieve the real component to be rendered
      function getRealChild(vnode) {
        var compOptions = vnode && vnode.componentOptions;
        if (compOptions && compOptions.Ctor.options.abstract) {
          return getRealChild(getFirstComponentChild(compOptions.children));
        }
        else {
          return vnode;
        }
      }
      function extractTransitionData(comp) {
        var data = {};
        var options = comp.$options;
        // props
        for (var key in options.propsData) {
          data[key] = comp[key];
        }
        // events.
        // extract listeners and pass them directly to the transition methods
        var listeners = options._parentListeners;
        for (var key in listeners) {
          data[camelize(key)] = listeners[key];
        }
        return data;
      }
      function placeholder(h, rawChild) {
        // @ts-expect-error
        if (/\d-keep-alive$/.test(rawChild.tag)) {
          return h('keep-alive', {
            props: rawChild.componentOptions.propsData
          });
        }
      }
      function hasParentTransition(vnode) {
        while ((vnode = vnode.parent)) {
          if (vnode.data.transition) {
            return true;
          }
        }
      }
      function isSameChild(child, oldChild) {
        return oldChild.key === child.key && oldChild.tag === child.tag;
      }
      var isNotTextNode = function (c) { return c.tag || isAsyncPlaceholder(c); };
      var isVShowDirective = function (d) { return d.name === 'show'; };
      var Transition = {
        name: 'transition',
        props: transitionProps,
        abstract: true,
        render: function (h) {
          var _this = this;
          var children = this.$slots.default;
          if (!children) {
            return;
          }
          // filter out text nodes (possible whitespaces)
          children = children.filter(isNotTextNode);
          /* istanbul ignore if */
          if (!children.length) {
            return;
          }
          // warn multiple elements
          if ( true && children.length > 1) {
            warn$2('<transition> can only be used on a single element. Use ' +
                '<transition-group> for lists.', this.$parent);
          }
          var mode = this.mode;
          // warn invalid mode
          if ( true && mode && mode !== 'in-out' && mode !== 'out-in') {
            warn$2('invalid <transition> mode: ' + mode, this.$parent);
          }
          var rawChild = children[0];
          // if this is a component root node and the component's
          // parent container node also has transition, skip.
          if (hasParentTransition(this.$vnode)) {
            return rawChild;
          }
          // apply transition data to child
          // use getRealChild() to ignore abstract components e.g. keep-alive
          var child = getRealChild(rawChild);
          /* istanbul ignore if */
          if (!child) {
            return rawChild;
          }
          if (this._leaving) {
            return placeholder(h, rawChild);
          }
          // ensure a key that is unique to the vnode type and to this transition
          // component instance. This key will be used to remove pending leaving nodes
          // during entering.
          var id = "__transition-".concat(this._uid, "-");
          child.key =
              child.key == null
                  ? child.isComment
                  ? id + 'comment'
                  : id + child.tag
                  : isPrimitive(child.key)
                  ? String(child.key).indexOf(id) === 0
                      ? child.key
                      : id + child.key
                  : child.key;
          var data = ((child.data || (child.data = {})).transition =
              extractTransitionData(this));
          var oldRawChild = this._vnode;
          var oldChild = getRealChild(oldRawChild);
          // mark v-show
          // so that the transition module can hand over the control to the directive
          if (child.data.directives && child.data.directives.some(isVShowDirective)) {
            child.data.show = true;
          }
          if (oldChild &&
              oldChild.data &&
              !isSameChild(child, oldChild) &&
              !isAsyncPlaceholder(oldChild) &&
              // #6687 component root is a comment node
              !(oldChild.componentInstance &&
                  oldChild.componentInstance._vnode.isComment)) {
            // replace old child transition data with fresh one
            // important for dynamic transitions!
            var oldData = (oldChild.data.transition = extend({}, data));
            // handle transition mode
            if (mode === 'out-in') {
              // return placeholder node and queue update when leave finishes
              this._leaving = true;
              mergeVNodeHook(oldData, 'afterLeave', function () {
                _this._leaving = false;
                _this.$forceUpdate();
              });
              return placeholder(h, rawChild);
            }
            else if (mode === 'in-out') {
              if (isAsyncPlaceholder(child)) {
                return oldRawChild;
              }
              var delayedLeave_1;
              var performLeave = function () {
                delayedLeave_1();
              };
              mergeVNodeHook(data, 'afterEnter', performLeave);
              mergeVNodeHook(data, 'enterCancelled', performLeave);
              mergeVNodeHook(oldData, 'delayLeave', function (leave) {
                delayedLeave_1 = leave;
              });
            }
          }
          return rawChild;
        }
      };

// Provides transition support for list items.
      var props = extend({
        tag: String,
        moveClass: String
      }, transitionProps);
      delete props.mode;
      var TransitionGroup = {
        props: props,
        beforeMount: function () {
          var _this = this;
          var update = this._update;
          this._update = function (vnode, hydrating) {
            var restoreActiveInstance = setActiveInstance(_this);
            // force removing pass
            _this.__patch__(_this._vnode, _this.kept, false, // hydrating
                true // removeOnly (!important, avoids unnecessary moves)
            );
            _this._vnode = _this.kept;
            restoreActiveInstance();
            update.call(_this, vnode, hydrating);
          };
        },
        render: function (h) {
          var tag = this.tag || this.$vnode.data.tag || 'span';
          var map = Object.create(null);
          var prevChildren = (this.prevChildren = this.children);
          var rawChildren = this.$slots.default || [];
          var children = (this.children = []);
          var transitionData = extractTransitionData(this);
          for (var i = 0; i < rawChildren.length; i++) {
            var c = rawChildren[i];
            if (c.tag) {
              if (c.key != null && String(c.key).indexOf('__vlist') !== 0) {
                children.push(c);
                map[c.key] = c;
                (c.data || (c.data = {})).transition = transitionData;
              }
              else if (true) {
                var opts = c.componentOptions;
                var name_1 = opts
                    ? getComponentName(opts.Ctor.options) || opts.tag || ''
                    : c.tag;
                warn$2("<transition-group> children must be keyed: <".concat(name_1, ">"));
              }
            }
          }
          if (prevChildren) {
            var kept = [];
            var removed = [];
            for (var i = 0; i < prevChildren.length; i++) {
              var c = prevChildren[i];
              c.data.transition = transitionData;
              // @ts-expect-error .getBoundingClientRect is not typed in Node
              c.data.pos = c.elm.getBoundingClientRect();
              if (map[c.key]) {
                kept.push(c);
              }
              else {
                removed.push(c);
              }
            }
            this.kept = h(tag, null, kept);
            this.removed = removed;
          }
          return h(tag, null, children);
        },
        updated: function () {
          var children = this.prevChildren;
          var moveClass = this.moveClass || (this.name || 'v') + '-move';
          if (!children.length || !this.hasMove(children[0].elm, moveClass)) {
            return;
          }
          // we divide the work into three loops to avoid mixing DOM reads and writes
          // in each iteration - which helps prevent layout thrashing.
          children.forEach(callPendingCbs);
          children.forEach(recordPosition);
          children.forEach(applyTranslation);
          // force reflow to put everything in position
          // assign to this to avoid being removed in tree-shaking
          // $flow-disable-line
          this._reflow = document.body.offsetHeight;
          children.forEach(function (c) {
            if (c.data.moved) {
              var el_1 = c.elm;
              var s = el_1.style;
              addTransitionClass(el_1, moveClass);
              s.transform = s.WebkitTransform = s.transitionDuration = '';
              el_1.addEventListener(transitionEndEvent, (el_1._moveCb = function cb(e) {
                if (e && e.target !== el_1) {
                  return;
                }
                if (!e || /transform$/.test(e.propertyName)) {
                  el_1.removeEventListener(transitionEndEvent, cb);
                  el_1._moveCb = null;
                  removeTransitionClass(el_1, moveClass);
                }
              }));
            }
          });
        },
        methods: {
          hasMove: function (el, moveClass) {
            /* istanbul ignore if */
            if (!hasTransition) {
              return false;
            }
            /* istanbul ignore if */
            if (this._hasMove) {
              return this._hasMove;
            }
            // Detect whether an element with the move class applied has
            // CSS transitions. Since the element may be inside an entering
            // transition at this very moment, we make a clone of it and remove
            // all other transition classes applied to ensure only the move class
            // is applied.
            var clone = el.cloneNode();
            if (el._transitionClasses) {
              el._transitionClasses.forEach(function (cls) {
                removeClass(clone, cls);
              });
            }
            addClass(clone, moveClass);
            clone.style.display = 'none';
            this.$el.appendChild(clone);
            var info = getTransitionInfo(clone);
            this.$el.removeChild(clone);
            return (this._hasMove = info.hasTransform);
          }
        }
      };
      function callPendingCbs(c) {
        /* istanbul ignore if */
        if (c.elm._moveCb) {
          c.elm._moveCb();
        }
        /* istanbul ignore if */
        if (c.elm._enterCb) {
          c.elm._enterCb();
        }
      }
      function recordPosition(c) {
        c.data.newPos = c.elm.getBoundingClientRect();
      }
      function applyTranslation(c) {
        var oldPos = c.data.pos;
        var newPos = c.data.newPos;
        var dx = oldPos.left - newPos.left;
        var dy = oldPos.top - newPos.top;
        if (dx || dy) {
          c.data.moved = true;
          var s = c.elm.style;
          s.transform = s.WebkitTransform = "translate(".concat(dx, "px,").concat(dy, "px)");
          s.transitionDuration = '0s';
        }
      }

      var platformComponents = {
        Transition: Transition,
        TransitionGroup: TransitionGroup
      };

// install platform specific utils
      Vue.config.mustUseProp = mustUseProp;
      Vue.config.isReservedTag = isReservedTag;
      Vue.config.isReservedAttr = isReservedAttr;
      Vue.config.getTagNamespace = getTagNamespace;
      Vue.config.isUnknownElement = isUnknownElement;
// install platform runtime directives & components
      extend(Vue.options.directives, platformDirectives);
      extend(Vue.options.components, platformComponents);
// install platform patch function
      Vue.prototype.__patch__ = inBrowser ? patch : noop;
// public mount method
      Vue.prototype.$mount = function (el, hydrating) {
        el = el && inBrowser ? query(el) : undefined;
        return mountComponent(this, el, hydrating);
      };
// devtools global hook
      /* istanbul ignore next */
      if (inBrowser) {
        setTimeout(function () {
          if (config.devtools) {
            if (devtools) {
              devtools.emit('init', Vue);
            }
            else if (true) {
              // @ts-expect-error
              console[console.info ? 'info' : 'log']('Download the Vue Devtools extension for a better development experience:\n' +
                  'https://github.com/vuejs/vue-devtools');
            }
          }
          if ( true &&
              config.productionTip !== false &&
              typeof console !== 'undefined') {
            // @ts-expect-error
            console[console.info ? 'info' : 'log']("You are running Vue in development mode.\n" +
                "Make sure to turn on production mode when deploying for production.\n" +
                "See more tips at https://vuejs.org/guide/deployment.html");
          }
        }, 0);
      }

      var defaultTagRE = /\{\{((?:.|\r?\n)+?)\}\}/g;
      var regexEscapeRE = /[-.*+?^${}()|[\]\/\\]/g;
      var buildRegex = cached(function (delimiters) {
        var open = delimiters[0].replace(regexEscapeRE, '\\$&');
        var close = delimiters[1].replace(regexEscapeRE, '\\$&');
        return new RegExp(open + '((?:.|\\n)+?)' + close, 'g');
      });
      function parseText(text, delimiters) {
        //@ts-expect-error
        var tagRE = delimiters ? buildRegex(delimiters) : defaultTagRE;
        if (!tagRE.test(text)) {
          return;
        }
        var tokens = [];
        var rawTokens = [];
        var lastIndex = (tagRE.lastIndex = 0);
        var match, index, tokenValue;
        while ((match = tagRE.exec(text))) {
          index = match.index;
          // push text token
          if (index > lastIndex) {
            rawTokens.push((tokenValue = text.slice(lastIndex, index)));
            tokens.push(JSON.stringify(tokenValue));
          }
          // tag token
          var exp = parseFilters(match[1].trim());
          tokens.push("_s(".concat(exp, ")"));
          rawTokens.push({ '@binding': exp });
          lastIndex = index + match[0].length;
        }
        if (lastIndex < text.length) {
          rawTokens.push((tokenValue = text.slice(lastIndex)));
          tokens.push(JSON.stringify(tokenValue));
        }
        return {
          expression: tokens.join('+'),
          tokens: rawTokens
        };
      }

      function transformNode$1(el, options) {
        var warn = options.warn || baseWarn;
        var staticClass = getAndRemoveAttr(el, 'class');
        if ( true && staticClass) {
          var res = parseText(staticClass, options.delimiters);
          if (res) {
            warn("class=\"".concat(staticClass, "\": ") +
                'Interpolation inside attributes has been removed. ' +
                'Use v-bind or the colon shorthand instead. For example, ' +
                'instead of <div class="{{ val }}">, use <div :class="val">.', el.rawAttrsMap['class']);
          }
        }
        if (staticClass) {
          el.staticClass = JSON.stringify(staticClass.replace(/\s+/g, ' ').trim());
        }
        var classBinding = getBindingAttr(el, 'class', false /* getStatic */);
        if (classBinding) {
          el.classBinding = classBinding;
        }
      }
      function genData$2(el) {
        var data = '';
        if (el.staticClass) {
          data += "staticClass:".concat(el.staticClass, ",");
        }
        if (el.classBinding) {
          data += "class:".concat(el.classBinding, ",");
        }
        return data;
      }
      var klass = {
        staticKeys: ['staticClass'],
        transformNode: transformNode$1,
        genData: genData$2
      };

      function transformNode(el, options) {
        var warn = options.warn || baseWarn;
        var staticStyle = getAndRemoveAttr(el, 'style');
        if (staticStyle) {
          /* istanbul ignore if */
          if (true) {
            var res = parseText(staticStyle, options.delimiters);
            if (res) {
              warn("style=\"".concat(staticStyle, "\": ") +
                  'Interpolation inside attributes has been removed. ' +
                  'Use v-bind or the colon shorthand instead. For example, ' +
                  'instead of <div style="{{ val }}">, use <div :style="val">.', el.rawAttrsMap['style']);
            }
          }
          el.staticStyle = JSON.stringify(parseStyleText(staticStyle));
        }
        var styleBinding = getBindingAttr(el, 'style', false /* getStatic */);
        if (styleBinding) {
          el.styleBinding = styleBinding;
        }
      }
      function genData$1(el) {
        var data = '';
        if (el.staticStyle) {
          data += "staticStyle:".concat(el.staticStyle, ",");
        }
        if (el.styleBinding) {
          data += "style:(".concat(el.styleBinding, "),");
        }
        return data;
      }
      var style = {
        staticKeys: ['staticStyle'],
        transformNode: transformNode,
        genData: genData$1
      };

      var decoder;
      var he = {
        decode: function (html) {
          decoder = decoder || document.createElement('div');
          decoder.innerHTML = html;
          return decoder.textContent;
        }
      };

      var isUnaryTag = makeMap('area,base,br,col,embed,frame,hr,img,input,isindex,keygen,' +
          'link,meta,param,source,track,wbr');
// Elements that you can, intentionally, leave open
// (and which close themselves)
      var canBeLeftOpenTag = makeMap('colgroup,dd,dt,li,options,p,td,tfoot,th,thead,tr,source');
// HTML5 tags https://html.spec.whatwg.org/multipage/indices.html#elements-3
// Phrasing Content https://html.spec.whatwg.org/multipage/dom.html#phrasing-content
      var isNonPhrasingTag = makeMap('address,article,aside,base,blockquote,body,caption,col,colgroup,dd,' +
          'details,dialog,div,dl,dt,fieldset,figcaption,figure,footer,form,' +
          'h1,h2,h3,h4,h5,h6,head,header,hgroup,hr,html,legend,li,menuitem,meta,' +
          'optgroup,option,param,rp,rt,source,style,summary,tbody,td,tfoot,th,thead,' +
          'title,tr,track');

      /**
       * Not type-checking this file because it's mostly vendor code.
       */
// Regular Expressions for parsing tags and attributes
      var attribute = /^\s*([^\s"'<>\/=]+)(?:\s*(=)\s*(?:"([^"]*)"+|'([^']*)'+|([^\s"'=<>`]+)))?/;
      var dynamicArgAttribute = /^\s*((?:v-[\w-]+:|@|:|#)\[[^=]+?\][^\s"'<>\/=]*)(?:\s*(=)\s*(?:"([^"]*)"+|'([^']*)'+|([^\s"'=<>`]+)))?/;
      var ncname = "[a-zA-Z_][\\-\\.0-9_a-zA-Z".concat(unicodeRegExp.source, "]*");
      var qnameCapture = "((?:".concat(ncname, "\\:)?").concat(ncname, ")");
      var startTagOpen = new RegExp("^<".concat(qnameCapture));
      var startTagClose = /^\s*(\/?)>/;
      var endTag = new RegExp("^<\\/".concat(qnameCapture, "[^>]*>"));
      var doctype = /^<!DOCTYPE [^>]+>/i;
// #7298: escape - to avoid being passed as HTML comment when inlined in page
      var comment = /^<!\--/;
      var conditionalComment = /^<!\[/;
// Special Elements (can contain anything)
      var isPlainTextElement = makeMap('script,style,textarea', true);
      var reCache = {};
      var decodingMap = {
        '&lt;': '<',
        '&gt;': '>',
        '&quot;': '"',
        '&amp;': '&',
        '&#10;': '\n',
        '&#9;': '\t',
        '&#39;': "'"
      };
      var encodedAttr = /&(?:lt|gt|quot|amp|#39);/g;
      var encodedAttrWithNewLines = /&(?:lt|gt|quot|amp|#39|#10|#9);/g;
// #5992
      var isIgnoreNewlineTag = makeMap('pre,textarea', true);
      var shouldIgnoreFirstNewline = function (tag, html) {
        return tag && isIgnoreNewlineTag(tag) && html[0] === '\n';
      };
      function decodeAttr(value, shouldDecodeNewlines) {
        var re = shouldDecodeNewlines ? encodedAttrWithNewLines : encodedAttr;
        return value.replace(re, function (match) { return decodingMap[match]; });
      }
      function parseHTML(html, options) {
        var stack = [];
        var expectHTML = options.expectHTML;
        var isUnaryTag = options.isUnaryTag || no;
        var canBeLeftOpenTag = options.canBeLeftOpenTag || no;
        var index = 0;
        var last, lastTag;
        var _loop_1 = function () {
          last = html;
          // Make sure we're not in a plaintext content element like script/style
          if (!lastTag || !isPlainTextElement(lastTag)) {
            var textEnd = html.indexOf('<');
            if (textEnd === 0) {
              // Comment:
              if (comment.test(html)) {
                var commentEnd = html.indexOf('-->');
                if (commentEnd >= 0) {
                  if (options.shouldKeepComment && options.comment) {
                    options.comment(html.substring(4, commentEnd), index, index + commentEnd + 3);
                  }
                  advance(commentEnd + 3);
                  return "continue";
                }
              }
              // http://en.wikipedia.org/wiki/Conditional_comment#Downlevel-revealed_conditional_comment
              if (conditionalComment.test(html)) {
                var conditionalEnd = html.indexOf(']>');
                if (conditionalEnd >= 0) {
                  advance(conditionalEnd + 2);
                  return "continue";
                }
              }
              // Doctype:
              var doctypeMatch = html.match(doctype);
              if (doctypeMatch) {
                advance(doctypeMatch[0].length);
                return "continue";
              }
              // End tag:
              var endTagMatch = html.match(endTag);
              if (endTagMatch) {
                var curIndex = index;
                advance(endTagMatch[0].length);
                parseEndTag(endTagMatch[1], curIndex, index);
                return "continue";
              }
              // Start tag:
              var startTagMatch = parseStartTag();
              if (startTagMatch) {
                handleStartTag(startTagMatch);
                if (shouldIgnoreFirstNewline(startTagMatch.tagName, html)) {
                  advance(1);
                }
                return "continue";
              }
            }
            var text = void 0, rest = void 0, next = void 0;
            if (textEnd >= 0) {
              rest = html.slice(textEnd);
              while (!endTag.test(rest) &&
              !startTagOpen.test(rest) &&
              !comment.test(rest) &&
              !conditionalComment.test(rest)) {
                // < in plain text, be forgiving and treat it as text
                next = rest.indexOf('<', 1);
                if (next < 0)
                  break;
                textEnd += next;
                rest = html.slice(textEnd);
              }
              text = html.substring(0, textEnd);
            }
            if (textEnd < 0) {
              text = html;
            }
            if (text) {
              advance(text.length);
            }
            if (options.chars && text) {
              options.chars(text, index - text.length, index);
            }
          }
          else {
            var endTagLength_1 = 0;
            var stackedTag_1 = lastTag.toLowerCase();
            var reStackedTag = reCache[stackedTag_1] ||
                (reCache[stackedTag_1] = new RegExp('([\\s\\S]*?)(</' + stackedTag_1 + '[^>]*>)', 'i'));
            var rest = html.replace(reStackedTag, function (all, text, endTag) {
              endTagLength_1 = endTag.length;
              if (!isPlainTextElement(stackedTag_1) && stackedTag_1 !== 'noscript') {
                text = text
                    .replace(/<!\--([\s\S]*?)-->/g, '$1') // #7298
                    .replace(/<!\[CDATA\[([\s\S]*?)]]>/g, '$1');
              }
              if (shouldIgnoreFirstNewline(stackedTag_1, text)) {
                text = text.slice(1);
              }
              if (options.chars) {
                options.chars(text);
              }
              return '';
            });
            index += html.length - rest.length;
            html = rest;
            parseEndTag(stackedTag_1, index - endTagLength_1, index);
          }
          if (html === last) {
            options.chars && options.chars(html);
            if ( true && !stack.length && options.warn) {
              options.warn("Mal-formatted tag at end of template: \"".concat(html, "\""), {
                start: index + html.length
              });
            }
            return "break";
          }
        };
        while (html) {
          var state_1 = _loop_1();
          if (state_1 === "break")
            break;
        }
        // Clean up any remaining tags
        parseEndTag();
        function advance(n) {
          index += n;
          html = html.substring(n);
        }
        function parseStartTag() {
          var start = html.match(startTagOpen);
          if (start) {
            var match = {
              tagName: start[1],
              attrs: [],
              start: index
            };
            advance(start[0].length);
            var end = void 0, attr = void 0;
            while (!(end = html.match(startTagClose)) &&
            (attr = html.match(dynamicArgAttribute) || html.match(attribute))) {
              attr.start = index;
              advance(attr[0].length);
              attr.end = index;
              match.attrs.push(attr);
            }
            if (end) {
              match.unarySlash = end[1];
              advance(end[0].length);
              match.end = index;
              return match;
            }
          }
        }
        function handleStartTag(match) {
          var tagName = match.tagName;
          var unarySlash = match.unarySlash;
          if (expectHTML) {
            if (lastTag === 'p' && isNonPhrasingTag(tagName)) {
              parseEndTag(lastTag);
            }
            if (canBeLeftOpenTag(tagName) && lastTag === tagName) {
              parseEndTag(tagName);
            }
          }
          var unary = isUnaryTag(tagName) || !!unarySlash;
          var l = match.attrs.length;
          var attrs = new Array(l);
          for (var i = 0; i < l; i++) {
            var args = match.attrs[i];
            var value = args[3] || args[4] || args[5] || '';
            var shouldDecodeNewlines = tagName === 'a' && args[1] === 'href'
                ? options.shouldDecodeNewlinesForHref
                : options.shouldDecodeNewlines;
            attrs[i] = {
              name: args[1],
              value: decodeAttr(value, shouldDecodeNewlines)
            };
            if ( true && options.outputSourceRange) {
              attrs[i].start = args.start + args[0].match(/^\s*/).length;
              attrs[i].end = args.end;
            }
          }
          if (!unary) {
            stack.push({
              tag: tagName,
              lowerCasedTag: tagName.toLowerCase(),
              attrs: attrs,
              start: match.start,
              end: match.end
            });
            lastTag = tagName;
          }
          if (options.start) {
            options.start(tagName, attrs, unary, match.start, match.end);
          }
        }
        function parseEndTag(tagName, start, end) {
          var pos, lowerCasedTagName;
          if (start == null)
            start = index;
          if (end == null)
            end = index;
          // Find the closest opened tag of the same type
          if (tagName) {
            lowerCasedTagName = tagName.toLowerCase();
            for (pos = stack.length - 1; pos >= 0; pos--) {
              if (stack[pos].lowerCasedTag === lowerCasedTagName) {
                break;
              }
            }
          }
          else {
            // If no tag name is provided, clean shop
            pos = 0;
          }
          if (pos >= 0) {
            // Close all the open elements, up the stack
            for (var i = stack.length - 1; i >= pos; i--) {
              if ( true && (i > pos || !tagName) && options.warn) {
                options.warn("tag <".concat(stack[i].tag, "> has no matching end tag."), {
                  start: stack[i].start,
                  end: stack[i].end
                });
              }
              if (options.end) {
                options.end(stack[i].tag, start, end);
              }
            }
            // Remove the open elements from the stack
            stack.length = pos;
            lastTag = pos && stack[pos - 1].tag;
          }
          else if (lowerCasedTagName === 'br') {
            if (options.start) {
              options.start(tagName, [], true, start, end);
            }
          }
          else if (lowerCasedTagName === 'p') {
            if (options.start) {
              options.start(tagName, [], false, start, end);
            }
            if (options.end) {
              options.end(tagName, start, end);
            }
          }
        }
      }

      var onRE = /^@|^v-on:/;
      var dirRE = /^v-|^@|^:|^#/;
      var forAliasRE = /([\s\S]*?)\s+(?:in|of)\s+([\s\S]*)/;
      var forIteratorRE = /,([^,\}\]]*)(?:,([^,\}\]]*))?$/;
      var stripParensRE = /^\(|\)$/g;
      var dynamicArgRE = /^\[.*\]$/;
      var argRE = /:(.*)$/;
      var bindRE = /^:|^\.|^v-bind:/;
      var modifierRE = /\.[^.\]]+(?=[^\]]*$)/g;
      var slotRE = /^v-slot(:|$)|^#/;
      var lineBreakRE = /[\r\n]/;
      var whitespaceRE = /[ \f\t\r\n]+/g;
      var invalidAttributeRE = /[\s"'<>\/=]/;
      var decodeHTMLCached = cached(he.decode);
      var emptySlotScopeToken = "_empty_";
// configurable state
      var warn;
      var delimiters;
      var transforms;
      var preTransforms;
      var postTransforms;
      var platformIsPreTag;
      var platformMustUseProp;
      var platformGetTagNamespace;
      var maybeComponent;
      function createASTElement(tag, attrs, parent) {
        return {
          type: 1,
          tag: tag,
          attrsList: attrs,
          attrsMap: makeAttrsMap(attrs),
          rawAttrsMap: {},
          parent: parent,
          children: []
        };
      }
      /**
       * Convert HTML string to AST.
       */
      function parse(template, options) {
        warn = options.warn || baseWarn;
        platformIsPreTag = options.isPreTag || no;
        platformMustUseProp = options.mustUseProp || no;
        platformGetTagNamespace = options.getTagNamespace || no;
        var isReservedTag = options.isReservedTag || no;
        maybeComponent = function (el) {
          return !!(el.component ||
              el.attrsMap[':is'] ||
              el.attrsMap['v-bind:is'] ||
              !(el.attrsMap.is ? isReservedTag(el.attrsMap.is) : isReservedTag(el.tag)));
        };
        transforms = pluckModuleFunction(options.modules, 'transformNode');
        preTransforms = pluckModuleFunction(options.modules, 'preTransformNode');
        postTransforms = pluckModuleFunction(options.modules, 'postTransformNode');
        delimiters = options.delimiters;
        var stack = [];
        var preserveWhitespace = options.preserveWhitespace !== false;
        var whitespaceOption = options.whitespace;
        var root;
        var currentParent;
        var inVPre = false;
        var inPre = false;
        var warned = false;
        function warnOnce(msg, range) {
          if (!warned) {
            warned = true;
            warn(msg, range);
          }
        }
        function closeElement(element) {
          trimEndingWhitespace(element);
          if (!inVPre && !element.processed) {
            element = processElement(element, options);
          }
          // tree management
          if (!stack.length && element !== root) {
            // allow root elements with v-if, v-else-if and v-else
            if (root.if && (element.elseif || element.else)) {
              if (true) {
                checkRootConstraints(element);
              }
              addIfCondition(root, {
                exp: element.elseif,
                block: element
              });
            }
            else if (true) {
              warnOnce("Component template should contain exactly one root element. " +
                  "If you are using v-if on multiple elements, " +
                  "use v-else-if to chain them instead.", { start: element.start });
            }
          }
          if (currentParent && !element.forbidden) {
            if (element.elseif || element.else) {
              processIfConditions(element, currentParent);
            }
            else {
              if (element.slotScope) {
                // scoped slot
                // keep it in the children list so that v-else(-if) conditions can
                // find it as the prev node.
                var name_1 = element.slotTarget || '"default"';
                (currentParent.scopedSlots || (currentParent.scopedSlots = {}))[name_1] = element;
              }
              currentParent.children.push(element);
              element.parent = currentParent;
            }
          }
          // final children cleanup
          // filter out scoped slots
          element.children = element.children.filter(function (c) { return !c.slotScope; });
          // remove trailing whitespace node again
          trimEndingWhitespace(element);
          // check pre state
          if (element.pre) {
            inVPre = false;
          }
          if (platformIsPreTag(element.tag)) {
            inPre = false;
          }
          // apply post-transforms
          for (var i = 0; i < postTransforms.length; i++) {
            postTransforms[i](element, options);
          }
        }
        function trimEndingWhitespace(el) {
          // remove trailing whitespace node
          if (!inPre) {
            var lastNode = void 0;
            while ((lastNode = el.children[el.children.length - 1]) &&
            lastNode.type === 3 &&
            lastNode.text === ' ') {
              el.children.pop();
            }
          }
        }
        function checkRootConstraints(el) {
          if (el.tag === 'slot' || el.tag === 'template') {
            warnOnce("Cannot use <".concat(el.tag, "> as component root element because it may ") +
                'contain multiple nodes.', { start: el.start });
          }
          if (el.attrsMap.hasOwnProperty('v-for')) {
            warnOnce('Cannot use v-for on stateful component root element because ' +
                'it renders multiple elements.', el.rawAttrsMap['v-for']);
          }
        }
        parseHTML(template, {
          warn: warn,
          expectHTML: options.expectHTML,
          isUnaryTag: options.isUnaryTag,
          canBeLeftOpenTag: options.canBeLeftOpenTag,
          shouldDecodeNewlines: options.shouldDecodeNewlines,
          shouldDecodeNewlinesForHref: options.shouldDecodeNewlinesForHref,
          shouldKeepComment: options.comments,
          outputSourceRange: options.outputSourceRange,
          start: function (tag, attrs, unary, start, end) {
            // check namespace.
            // inherit parent ns if there is one
            var ns = (currentParent && currentParent.ns) || platformGetTagNamespace(tag);
            // handle IE svg bug
            /* istanbul ignore if */
            if (isIE && ns === 'svg') {
              attrs = guardIESVGBug(attrs);
            }
            var element = createASTElement(tag, attrs, currentParent);
            if (ns) {
              element.ns = ns;
            }
            if (true) {
              if (options.outputSourceRange) {
                element.start = start;
                element.end = end;
                element.rawAttrsMap = element.attrsList.reduce(function (cumulated, attr) {
                  cumulated[attr.name] = attr;
                  return cumulated;
                }, {});
              }
              attrs.forEach(function (attr) {
                if (invalidAttributeRE.test(attr.name)) {
                  warn("Invalid dynamic argument expression: attribute names cannot contain " +
                      "spaces, quotes, <, >, / or =.", options.outputSourceRange
                      ? {
                        start: attr.start + attr.name.indexOf("["),
                        end: attr.start + attr.name.length
                      }
                      : undefined);
                }
              });
            }
            if (isForbiddenTag(element) && !isServerRendering()) {
              element.forbidden = true;
              true &&
              warn('Templates should only be responsible for mapping the state to the ' +
                  'UI. Avoid placing tags with side-effects in your templates, such as ' +
                  "<".concat(tag, ">") +
                  ', as they will not be parsed.', { start: element.start });
            }
            // apply pre-transforms
            for (var i = 0; i < preTransforms.length; i++) {
              element = preTransforms[i](element, options) || element;
            }
            if (!inVPre) {
              processPre(element);
              if (element.pre) {
                inVPre = true;
              }
            }
            if (platformIsPreTag(element.tag)) {
              inPre = true;
            }
            if (inVPre) {
              processRawAttrs(element);
            }
            else if (!element.processed) {
              // structural directives
              processFor(element);
              processIf(element);
              processOnce(element);
            }
            if (!root) {
              root = element;
              if (true) {
                checkRootConstraints(root);
              }
            }
            if (!unary) {
              currentParent = element;
              stack.push(element);
            }
            else {
              closeElement(element);
            }
          },
          end: function (tag, start, end) {
            var element = stack[stack.length - 1];
            // pop stack
            stack.length -= 1;
            currentParent = stack[stack.length - 1];
            if ( true && options.outputSourceRange) {
              element.end = end;
            }
            closeElement(element);
          },
          chars: function (text, start, end) {
            if (!currentParent) {
              if (true) {
                if (text === template) {
                  warnOnce('Component template requires a root element, rather than just text.', { start: start });
                }
                else if ((text = text.trim())) {
                  warnOnce("text \"".concat(text, "\" outside root element will be ignored."), {
                    start: start
                  });
                }
              }
              return;
            }
            // IE textarea placeholder bug
            /* istanbul ignore if */
            if (isIE &&
                currentParent.tag === 'textarea' &&
                currentParent.attrsMap.placeholder === text) {
              return;
            }
            var children = currentParent.children;
            if (inPre || text.trim()) {
              text = isTextTag(currentParent)
                  ? text
                  : decodeHTMLCached(text);
            }
            else if (!children.length) {
              // remove the whitespace-only node right after an opening tag
              text = '';
            }
            else if (whitespaceOption) {
              if (whitespaceOption === 'condense') {
                // in condense mode, remove the whitespace node if it contains
                // line break, otherwise condense to a single space
                text = lineBreakRE.test(text) ? '' : ' ';
              }
              else {
                text = ' ';
              }
            }
            else {
              text = preserveWhitespace ? ' ' : '';
            }
            if (text) {
              if (!inPre && whitespaceOption === 'condense') {
                // condense consecutive whitespaces into single space
                text = text.replace(whitespaceRE, ' ');
              }
              var res = void 0;
              var child = void 0;
              if (!inVPre && text !== ' ' && (res = parseText(text, delimiters))) {
                child = {
                  type: 2,
                  expression: res.expression,
                  tokens: res.tokens,
                  text: text
                };
              }
              else if (text !== ' ' ||
                  !children.length ||
                  children[children.length - 1].text !== ' ') {
                child = {
                  type: 3,
                  text: text
                };
              }
              if (child) {
                if ( true && options.outputSourceRange) {
                  child.start = start;
                  child.end = end;
                }
                children.push(child);
              }
            }
          },
          comment: function (text, start, end) {
            // adding anything as a sibling to the root node is forbidden
            // comments should still be allowed, but ignored
            if (currentParent) {
              var child = {
                type: 3,
                text: text,
                isComment: true
              };
              if ( true && options.outputSourceRange) {
                child.start = start;
                child.end = end;
              }
              currentParent.children.push(child);
            }
          }
        });
        return root;
      }
      function processPre(el) {
        if (getAndRemoveAttr(el, 'v-pre') != null) {
          el.pre = true;
        }
      }
      function processRawAttrs(el) {
        var list = el.attrsList;
        var len = list.length;
        if (len) {
          var attrs = (el.attrs = new Array(len));
          for (var i = 0; i < len; i++) {
            attrs[i] = {
              name: list[i].name,
              value: JSON.stringify(list[i].value)
            };
            if (list[i].start != null) {
              attrs[i].start = list[i].start;
              attrs[i].end = list[i].end;
            }
          }
        }
        else if (!el.pre) {
          // non root node in pre blocks with no attributes
          el.plain = true;
        }
      }
      function processElement(element, options) {
        processKey(element);
        // determine whether this is a plain element after
        // removing structural attributes
        element.plain =
            !element.key && !element.scopedSlots && !element.attrsList.length;
        processRef(element);
        processSlotContent(element);
        processSlotOutlet(element);
        processComponent(element);
        for (var i = 0; i < transforms.length; i++) {
          element = transforms[i](element, options) || element;
        }
        processAttrs(element);
        return element;
      }
      function processKey(el) {
        var exp = getBindingAttr(el, 'key');
        if (exp) {
          if (true) {
            if (el.tag === 'template') {
              warn("<template> cannot be keyed. Place the key on real elements instead.", getRawBindingAttr(el, 'key'));
            }
            if (el.for) {
              var iterator = el.iterator2 || el.iterator1;
              var parent_1 = el.parent;
              if (iterator &&
                  iterator === exp &&
                  parent_1 &&
                  parent_1.tag === 'transition-group') {
                warn("Do not use v-for index as key on <transition-group> children, " +
                    "this is the same as not using keys.", getRawBindingAttr(el, 'key'), true /* tip */);
              }
            }
          }
          el.key = exp;
        }
      }
      function processRef(el) {
        var ref = getBindingAttr(el, 'ref');
        if (ref) {
          el.ref = ref;
          el.refInFor = checkInFor(el);
        }
      }
      function processFor(el) {
        var exp;
        if ((exp = getAndRemoveAttr(el, 'v-for'))) {
          var res = parseFor(exp);
          if (res) {
            extend(el, res);
          }
          else if (true) {
            warn("Invalid v-for expression: ".concat(exp), el.rawAttrsMap['v-for']);
          }
        }
      }
      function parseFor(exp) {
        var inMatch = exp.match(forAliasRE);
        if (!inMatch)
          return;
        var res = {};
        res.for = inMatch[2].trim();
        var alias = inMatch[1].trim().replace(stripParensRE, '');
        var iteratorMatch = alias.match(forIteratorRE);
        if (iteratorMatch) {
          res.alias = alias.replace(forIteratorRE, '').trim();
          res.iterator1 = iteratorMatch[1].trim();
          if (iteratorMatch[2]) {
            res.iterator2 = iteratorMatch[2].trim();
          }
        }
        else {
          res.alias = alias;
        }
        return res;
      }
      function processIf(el) {
        var exp = getAndRemoveAttr(el, 'v-if');
        if (exp) {
          el.if = exp;
          addIfCondition(el, {
            exp: exp,
            block: el
          });
        }
        else {
          if (getAndRemoveAttr(el, 'v-else') != null) {
            el.else = true;
          }
          var elseif = getAndRemoveAttr(el, 'v-else-if');
          if (elseif) {
            el.elseif = elseif;
          }
        }
      }
      function processIfConditions(el, parent) {
        var prev = findPrevElement(parent.children);
        if (prev && prev.if) {
          addIfCondition(prev, {
            exp: el.elseif,
            block: el
          });
        }
        else if (true) {
          warn("v-".concat(el.elseif ? 'else-if="' + el.elseif + '"' : 'else', " ") +
              "used on element <".concat(el.tag, "> without corresponding v-if."), el.rawAttrsMap[el.elseif ? 'v-else-if' : 'v-else']);
        }
      }
      function findPrevElement(children) {
        var i = children.length;
        while (i--) {
          if (children[i].type === 1) {
            return children[i];
          }
          else {
            if ( true && children[i].text !== ' ') {
              warn("text \"".concat(children[i].text.trim(), "\" between v-if and v-else(-if) ") +
                  "will be ignored.", children[i]);
            }
            children.pop();
          }
        }
      }
      function addIfCondition(el, condition) {
        if (!el.ifConditions) {
          el.ifConditions = [];
        }
        el.ifConditions.push(condition);
      }
      function processOnce(el) {
        var once = getAndRemoveAttr(el, 'v-once');
        if (once != null) {
          el.once = true;
        }
      }
// handle content being passed to a component as slot,
// e.g. <template slot="xxx">, <div slot-scope="xxx">
      function processSlotContent(el) {
        var slotScope;
        if (el.tag === 'template') {
          slotScope = getAndRemoveAttr(el, 'scope');
          /* istanbul ignore if */
          if ( true && slotScope) {
            warn("the \"scope\" attribute for scoped slots have been deprecated and " +
                "replaced by \"slot-scope\" since 2.5. The new \"slot-scope\" attribute " +
                "can also be used on plain elements in addition to <template> to " +
                "denote scoped slots.", el.rawAttrsMap['scope'], true);
          }
          el.slotScope = slotScope || getAndRemoveAttr(el, 'slot-scope');
        }
        else if ((slotScope = getAndRemoveAttr(el, 'slot-scope'))) {
          /* istanbul ignore if */
          if ( true && el.attrsMap['v-for']) {
            warn("Ambiguous combined usage of slot-scope and v-for on <".concat(el.tag, "> ") +
                "(v-for takes higher priority). Use a wrapper <template> for the " +
                "scoped slot to make it clearer.", el.rawAttrsMap['slot-scope'], true);
          }
          el.slotScope = slotScope;
        }
        // slot="xxx"
        var slotTarget = getBindingAttr(el, 'slot');
        if (slotTarget) {
          el.slotTarget = slotTarget === '""' ? '"default"' : slotTarget;
          el.slotTargetDynamic = !!(el.attrsMap[':slot'] || el.attrsMap['v-bind:slot']);
          // preserve slot as an attribute for native shadow DOM compat
          // only for non-scoped slots.
          if (el.tag !== 'template' && !el.slotScope) {
            addAttr(el, 'slot', slotTarget, getRawBindingAttr(el, 'slot'));
          }
        }
        // 2.6 v-slot syntax
        {
          if (el.tag === 'template') {
            // v-slot on <template>
            var slotBinding = getAndRemoveAttrByRegex(el, slotRE);
            if (slotBinding) {
              if (true) {
                if (el.slotTarget || el.slotScope) {
                  warn("Unexpected mixed usage of different slot syntaxes.", el);
                }
                if (el.parent && !maybeComponent(el.parent)) {
                  warn("<template v-slot> can only appear at the root level inside " +
                      "the receiving component", el);
                }
              }
              var _a = getSlotName(slotBinding), name_2 = _a.name, dynamic = _a.dynamic;
              el.slotTarget = name_2;
              el.slotTargetDynamic = dynamic;
              el.slotScope = slotBinding.value || emptySlotScopeToken; // force it into a scoped slot for perf
            }
          }
          else {
            // v-slot on component, denotes default slot
            var slotBinding = getAndRemoveAttrByRegex(el, slotRE);
            if (slotBinding) {
              if (true) {
                if (!maybeComponent(el)) {
                  warn("v-slot can only be used on components or <template>.", slotBinding);
                }
                if (el.slotScope || el.slotTarget) {
                  warn("Unexpected mixed usage of different slot syntaxes.", el);
                }
                if (el.scopedSlots) {
                  warn("To avoid scope ambiguity, the default slot should also use " +
                      "<template> syntax when there are other named slots.", slotBinding);
                }
              }
              // add the component's children to its default slot
              var slots = el.scopedSlots || (el.scopedSlots = {});
              var _b = getSlotName(slotBinding), name_3 = _b.name, dynamic = _b.dynamic;
              var slotContainer_1 = (slots[name_3] = createASTElement('template', [], el));
              slotContainer_1.slotTarget = name_3;
              slotContainer_1.slotTargetDynamic = dynamic;
              slotContainer_1.children = el.children.filter(function (c) {
                if (!c.slotScope) {
                  c.parent = slotContainer_1;
                  return true;
                }
              });
              slotContainer_1.slotScope = slotBinding.value || emptySlotScopeToken;
              // remove children as they are returned from scopedSlots now
              el.children = [];
              // mark el non-plain so data gets generated
              el.plain = false;
            }
          }
        }
      }
      function getSlotName(binding) {
        var name = binding.name.replace(slotRE, '');
        if (!name) {
          if (binding.name[0] !== '#') {
            name = 'default';
          }
          else if (true) {
            warn("v-slot shorthand syntax requires a slot name.", binding);
          }
        }
        return dynamicArgRE.test(name)
            ? // dynamic [name]
            { name: name.slice(1, -1), dynamic: true }
            : // static name
            { name: "\"".concat(name, "\""), dynamic: false };
      }
// handle <slot/> outlets
      function processSlotOutlet(el) {
        if (el.tag === 'slot') {
          el.slotName = getBindingAttr(el, 'name');
          if ( true && el.key) {
            warn("`key` does not work on <slot> because slots are abstract outlets " +
                "and can possibly expand into multiple elements. " +
                "Use the key on a wrapping element instead.", getRawBindingAttr(el, 'key'));
          }
        }
      }
      function processComponent(el) {
        var binding;
        if ((binding = getBindingAttr(el, 'is'))) {
          el.component = binding;
        }
        if (getAndRemoveAttr(el, 'inline-template') != null) {
          el.inlineTemplate = true;
        }
      }
      function processAttrs(el) {
        var list = el.attrsList;
        var i, l, name, rawName, value, modifiers, syncGen, isDynamic;
        for (i = 0, l = list.length; i < l; i++) {
          name = rawName = list[i].name;
          value = list[i].value;
          if (dirRE.test(name)) {
            // mark element as dynamic
            el.hasBindings = true;
            // modifiers
            modifiers = parseModifiers(name.replace(dirRE, ''));
            // support .foo shorthand syntax for the .prop modifier
            if (modifiers) {
              name = name.replace(modifierRE, '');
            }
            if (bindRE.test(name)) {
              // v-bind
              name = name.replace(bindRE, '');
              value = parseFilters(value);
              isDynamic = dynamicArgRE.test(name);
              if (isDynamic) {
                name = name.slice(1, -1);
              }
              if ( true && value.trim().length === 0) {
                warn("The value for a v-bind expression cannot be empty. Found in \"v-bind:".concat(name, "\""));
              }
              if (modifiers) {
                if (modifiers.prop && !isDynamic) {
                  name = camelize(name);
                  if (name === 'innerHtml')
                    name = 'innerHTML';
                }
                if (modifiers.camel && !isDynamic) {
                  name = camelize(name);
                }
                if (modifiers.sync) {
                  syncGen = genAssignmentCode(value, "$event");
                  if (!isDynamic) {
                    addHandler(el, "update:".concat(camelize(name)), syncGen, null, false, warn, list[i]);
                    if (hyphenate(name) !== camelize(name)) {
                      addHandler(el, "update:".concat(hyphenate(name)), syncGen, null, false, warn, list[i]);
                    }
                  }
                  else {
                    // handler w/ dynamic event name
                    addHandler(el, "\"update:\"+(".concat(name, ")"), syncGen, null, false, warn, list[i], true // dynamic
                    );
                  }
                }
              }
              if ((modifiers && modifiers.prop) ||
                  (!el.component && platformMustUseProp(el.tag, el.attrsMap.type, name))) {
                addProp(el, name, value, list[i], isDynamic);
              }
              else {
                addAttr(el, name, value, list[i], isDynamic);
              }
            }
            else if (onRE.test(name)) {
              // v-on
              name = name.replace(onRE, '');
              isDynamic = dynamicArgRE.test(name);
              if (isDynamic) {
                name = name.slice(1, -1);
              }
              addHandler(el, name, value, modifiers, false, warn, list[i], isDynamic);
            }
            else {
              // normal directives
              name = name.replace(dirRE, '');
              // parse arg
              var argMatch = name.match(argRE);
              var arg = argMatch && argMatch[1];
              isDynamic = false;
              if (arg) {
                name = name.slice(0, -(arg.length + 1));
                if (dynamicArgRE.test(arg)) {
                  arg = arg.slice(1, -1);
                  isDynamic = true;
                }
              }
              addDirective(el, name, rawName, value, arg, isDynamic, modifiers, list[i]);
              if ( true && name === 'model') {
                checkForAliasModel(el, value);
              }
            }
          }
          else {
            // literal attribute
            if (true) {
              var res = parseText(value, delimiters);
              if (res) {
                warn("".concat(name, "=\"").concat(value, "\": ") +
                    'Interpolation inside attributes has been removed. ' +
                    'Use v-bind or the colon shorthand instead. For example, ' +
                    'instead of <div id="{{ val }}">, use <div :id="val">.', list[i]);
              }
            }
            addAttr(el, name, JSON.stringify(value), list[i]);
            // #6887 firefox doesn't update muted state if set via attribute
            // even immediately after element creation
            if (!el.component &&
                name === 'muted' &&
                platformMustUseProp(el.tag, el.attrsMap.type, name)) {
              addProp(el, name, 'true', list[i]);
            }
          }
        }
      }
      function checkInFor(el) {
        var parent = el;
        while (parent) {
          if (parent.for !== undefined) {
            return true;
          }
          parent = parent.parent;
        }
        return false;
      }
      function parseModifiers(name) {
        var match = name.match(modifierRE);
        if (match) {
          var ret_1 = {};
          match.forEach(function (m) {
            ret_1[m.slice(1)] = true;
          });
          return ret_1;
        }
      }
      function makeAttrsMap(attrs) {
        var map = {};
        for (var i = 0, l = attrs.length; i < l; i++) {
          if ( true && map[attrs[i].name] && !isIE && !isEdge) {
            warn('duplicate attribute: ' + attrs[i].name, attrs[i]);
          }
          map[attrs[i].name] = attrs[i].value;
        }
        return map;
      }
// for script (e.g. type="x/template") or style, do not decode content
      function isTextTag(el) {
        return el.tag === 'script' || el.tag === 'style';
      }
      function isForbiddenTag(el) {
        return (el.tag === 'style' ||
            (el.tag === 'script' &&
                (!el.attrsMap.type || el.attrsMap.type === 'text/javascript')));
      }
      var ieNSBug = /^xmlns:NS\d+/;
      var ieNSPrefix = /^NS\d+:/;
      /* istanbul ignore next */
      function guardIESVGBug(attrs) {
        var res = [];
        for (var i = 0; i < attrs.length; i++) {
          var attr = attrs[i];
          if (!ieNSBug.test(attr.name)) {
            attr.name = attr.name.replace(ieNSPrefix, '');
            res.push(attr);
          }
        }
        return res;
      }
      function checkForAliasModel(el, value) {
        var _el = el;
        while (_el) {
          if (_el.for && _el.alias === value) {
            warn("<".concat(el.tag, " v-model=\"").concat(value, "\">: ") +
                "You are binding v-model directly to a v-for iteration alias. " +
                "This will not be able to modify the v-for source array because " +
                "writing to the alias is like modifying a function local variable. " +
                "Consider using an array of objects and use v-model on an object property instead.", el.rawAttrsMap['v-model']);
          }
          _el = _el.parent;
        }
      }

      /**
       * Expand input[v-model] with dynamic type bindings into v-if-else chains
       * Turn this:
       *   <input v-model="data[type]" :type="type">
       * into this:
       *   <input v-if="type === 'checkbox'" type="checkbox" v-model="data[type]">
       *   <input v-else-if="type === 'radio'" type="radio" v-model="data[type]">
       *   <input v-else :type="type" v-model="data[type]">
       */
      function preTransformNode(el, options) {
        if (el.tag === 'input') {
          var map = el.attrsMap;
          if (!map['v-model']) {
            return;
          }
          var typeBinding = void 0;
          if (map[':type'] || map['v-bind:type']) {
            typeBinding = getBindingAttr(el, 'type');
          }
          if (!map.type && !typeBinding && map['v-bind']) {
            typeBinding = "(".concat(map['v-bind'], ").type");
          }
          if (typeBinding) {
            var ifCondition = getAndRemoveAttr(el, 'v-if', true);
            var ifConditionExtra = ifCondition ? "&&(".concat(ifCondition, ")") : "";
            var hasElse = getAndRemoveAttr(el, 'v-else', true) != null;
            var elseIfCondition = getAndRemoveAttr(el, 'v-else-if', true);
            // 1. checkbox
            var branch0 = cloneASTElement(el);
            // process for on the main node
            processFor(branch0);
            addRawAttr(branch0, 'type', 'checkbox');
            processElement(branch0, options);
            branch0.processed = true; // prevent it from double-processed
            branch0.if = "(".concat(typeBinding, ")==='checkbox'") + ifConditionExtra;
            addIfCondition(branch0, {
              exp: branch0.if,
              block: branch0
            });
            // 2. add radio else-if condition
            var branch1 = cloneASTElement(el);
            getAndRemoveAttr(branch1, 'v-for', true);
            addRawAttr(branch1, 'type', 'radio');
            processElement(branch1, options);
            addIfCondition(branch0, {
              exp: "(".concat(typeBinding, ")==='radio'") + ifConditionExtra,
              block: branch1
            });
            // 3. other
            var branch2 = cloneASTElement(el);
            getAndRemoveAttr(branch2, 'v-for', true);
            addRawAttr(branch2, ':type', typeBinding);
            processElement(branch2, options);
            addIfCondition(branch0, {
              exp: ifCondition,
              block: branch2
            });
            if (hasElse) {
              branch0.else = true;
            }
            else if (elseIfCondition) {
              branch0.elseif = elseIfCondition;
            }
            return branch0;
          }
        }
      }
      function cloneASTElement(el) {
        return createASTElement(el.tag, el.attrsList.slice(), el.parent);
      }
      var model = {
        preTransformNode: preTransformNode
      };

      var modules = [klass, style, model];

      function text(el, dir) {
        if (dir.value) {
          addProp(el, 'textContent', "_s(".concat(dir.value, ")"), dir);
        }
      }

      function html(el, dir) {
        if (dir.value) {
          addProp(el, 'innerHTML', "_s(".concat(dir.value, ")"), dir);
        }
      }

      var directives = {
        model: model$1,
        text: text,
        html: html
      };

      var baseOptions = {
        expectHTML: true,
        modules: modules,
        directives: directives,
        isPreTag: isPreTag,
        isUnaryTag: isUnaryTag,
        mustUseProp: mustUseProp,
        canBeLeftOpenTag: canBeLeftOpenTag,
        isReservedTag: isReservedTag,
        getTagNamespace: getTagNamespace,
        staticKeys: genStaticKeys$1(modules)
      };

      var isStaticKey;
      var isPlatformReservedTag;
      var genStaticKeysCached = cached(genStaticKeys);
      /**
       * Goal of the optimizer: walk the generated template AST tree
       * and detect sub-trees that are purely static, i.e. parts of
       * the DOM that never needs to change.
       *
       * Once we detect these sub-trees, we can:
       *
       * 1. Hoist them into constants, so that we no longer need to
       *    create fresh nodes for them on each re-render;
       * 2. Completely skip them in the patching process.
       */
      function optimize(root, options) {
        if (!root)
          return;
        isStaticKey = genStaticKeysCached(options.staticKeys || '');
        isPlatformReservedTag = options.isReservedTag || no;
        // first pass: mark all non-static nodes.
        markStatic(root);
        // second pass: mark static roots.
        markStaticRoots(root, false);
      }
      function genStaticKeys(keys) {
        return makeMap('type,tag,attrsList,attrsMap,plain,parent,children,attrs,start,end,rawAttrsMap' +
            (keys ? ',' + keys : ''));
      }
      function markStatic(node) {
        node.static = isStatic(node);
        if (node.type === 1) {
          // do not make component slot content static. this avoids
          // 1. components not able to mutate slot nodes
          // 2. static slot content fails for hot-reloading
          if (!isPlatformReservedTag(node.tag) &&
              node.tag !== 'slot' &&
              node.attrsMap['inline-template'] == null) {
            return;
          }
          for (var i = 0, l = node.children.length; i < l; i++) {
            var child = node.children[i];
            markStatic(child);
            if (!child.static) {
              node.static = false;
            }
          }
          if (node.ifConditions) {
            for (var i = 1, l = node.ifConditions.length; i < l; i++) {
              var block = node.ifConditions[i].block;
              markStatic(block);
              if (!block.static) {
                node.static = false;
              }
            }
          }
        }
      }
      function markStaticRoots(node, isInFor) {
        if (node.type === 1) {
          if (node.static || node.once) {
            node.staticInFor = isInFor;
          }
          // For a node to qualify as a static root, it should have children that
          // are not just static text. Otherwise the cost of hoisting out will
          // outweigh the benefits and it's better off to just always render it fresh.
          if (node.static &&
              node.children.length &&
              !(node.children.length === 1 && node.children[0].type === 3)) {
            node.staticRoot = true;
            return;
          }
          else {
            node.staticRoot = false;
          }
          if (node.children) {
            for (var i = 0, l = node.children.length; i < l; i++) {
              markStaticRoots(node.children[i], isInFor || !!node.for);
            }
          }
          if (node.ifConditions) {
            for (var i = 1, l = node.ifConditions.length; i < l; i++) {
              markStaticRoots(node.ifConditions[i].block, isInFor);
            }
          }
        }
      }
      function isStatic(node) {
        if (node.type === 2) {
          // expression
          return false;
        }
        if (node.type === 3) {
          // text
          return true;
        }
        return !!(node.pre ||
            (!node.hasBindings && // no dynamic bindings
                !node.if &&
                !node.for && // not v-if or v-for or v-else
                !isBuiltInTag(node.tag) && // not a built-in
                isPlatformReservedTag(node.tag) && // not a component
                !isDirectChildOfTemplateFor(node) &&
                Object.keys(node).every(isStaticKey)));
      }
      function isDirectChildOfTemplateFor(node) {
        while (node.parent) {
          node = node.parent;
          if (node.tag !== 'template') {
            return false;
          }
          if (node.for) {
            return true;
          }
        }
        return false;
      }

      var fnExpRE = /^([\w$_]+|\([^)]*?\))\s*=>|^function(?:\s+[\w$]+)?\s*\(/;
      var fnInvokeRE = /\([^)]*?\);*$/;
      var simplePathRE = /^[A-Za-z_$][\w$]*(?:\.[A-Za-z_$][\w$]*|\['[^']*?']|\["[^"]*?"]|\[\d+]|\[[A-Za-z_$][\w$]*])*$/;
// KeyboardEvent.keyCode aliases
      var keyCodes = {
        esc: 27,
        tab: 9,
        enter: 13,
        space: 32,
        up: 38,
        left: 37,
        right: 39,
        down: 40,
        delete: [8, 46]
      };
// KeyboardEvent.key aliases
      var keyNames = {
        // #7880: IE11 and Edge use `Esc` for Escape key name.
        esc: ['Esc', 'Escape'],
        tab: 'Tab',
        enter: 'Enter',
        // #9112: IE11 uses `Spacebar` for Space key name.
        space: [' ', 'Spacebar'],
        // #7806: IE11 uses key names without `Arrow` prefix for arrow keys.
        up: ['Up', 'ArrowUp'],
        left: ['Left', 'ArrowLeft'],
        right: ['Right', 'ArrowRight'],
        down: ['Down', 'ArrowDown'],
        // #9112: IE11 uses `Del` for Delete key name.
        delete: ['Backspace', 'Delete', 'Del']
      };
// #4868: modifiers that prevent the execution of the listener
// need to explicitly return null so that we can determine whether to remove
// the listener for .once
      var genGuard = function (condition) { return "if(".concat(condition, ")return null;"); };
      var modifierCode = {
        stop: '$event.stopPropagation();',
        prevent: '$event.preventDefault();',
        self: genGuard("$event.target !== $event.currentTarget"),
        ctrl: genGuard("!$event.ctrlKey"),
        shift: genGuard("!$event.shiftKey"),
        alt: genGuard("!$event.altKey"),
        meta: genGuard("!$event.metaKey"),
        left: genGuard("'button' in $event && $event.button !== 0"),
        middle: genGuard("'button' in $event && $event.button !== 1"),
        right: genGuard("'button' in $event && $event.button !== 2")
      };
      function genHandlers(events, isNative) {
        var prefix = isNative ? 'nativeOn:' : 'on:';
        var staticHandlers = "";
        var dynamicHandlers = "";
        for (var name_1 in events) {
          var handlerCode = genHandler(events[name_1]);
          //@ts-expect-error
          if (events[name_1] && events[name_1].dynamic) {
            dynamicHandlers += "".concat(name_1, ",").concat(handlerCode, ",");
          }
          else {
            staticHandlers += "\"".concat(name_1, "\":").concat(handlerCode, ",");
          }
        }
        staticHandlers = "{".concat(staticHandlers.slice(0, -1), "}");
        if (dynamicHandlers) {
          return prefix + "_d(".concat(staticHandlers, ",[").concat(dynamicHandlers.slice(0, -1), "])");
        }
        else {
          return prefix + staticHandlers;
        }
      }
      function genHandler(handler) {
        if (!handler) {
          return 'function(){}';
        }
        if (Array.isArray(handler)) {
          return "[".concat(handler.map(function (handler) { return genHandler(handler); }).join(','), "]");
        }
        var isMethodPath = simplePathRE.test(handler.value);
        var isFunctionExpression = fnExpRE.test(handler.value);
        var isFunctionInvocation = simplePathRE.test(handler.value.replace(fnInvokeRE, ''));
        if (!handler.modifiers) {
          if (isMethodPath || isFunctionExpression) {
            return handler.value;
          }
          return "function($event){".concat(isFunctionInvocation ? "return ".concat(handler.value) : handler.value, "}"); // inline statement
        }
        else {
          var code = '';
          var genModifierCode = '';
          var keys = [];
          var _loop_1 = function (key) {
            if (modifierCode[key]) {
              genModifierCode += modifierCode[key];
              // left/right
              if (keyCodes[key]) {
                keys.push(key);
              }
            }
            else if (key === 'exact') {
              var modifiers_1 = handler.modifiers;
              genModifierCode += genGuard(['ctrl', 'shift', 'alt', 'meta']
                  .filter(function (keyModifier) { return !modifiers_1[keyModifier]; })
                  .map(function (keyModifier) { return "$event.".concat(keyModifier, "Key"); })
                  .join('||'));
            }
            else {
              keys.push(key);
            }
          };
          for (var key in handler.modifiers) {
            _loop_1(key);
          }
          if (keys.length) {
            code += genKeyFilter(keys);
          }
          // Make sure modifiers like prevent and stop get executed after key filtering
          if (genModifierCode) {
            code += genModifierCode;
          }
          var handlerCode = isMethodPath
              ? "return ".concat(handler.value, ".apply(null, arguments)")
              : isFunctionExpression
                  ? "return (".concat(handler.value, ").apply(null, arguments)")
                  : isFunctionInvocation
                      ? "return ".concat(handler.value)
                      : handler.value;
          return "function($event){".concat(code).concat(handlerCode, "}");
        }
      }
      function genKeyFilter(keys) {
        return (
            // make sure the key filters only apply to KeyboardEvents
            // #9441: can't use 'keyCode' in $event because Chrome autofill fires fake
            // key events that do not have keyCode property...
            "if(!$event.type.indexOf('key')&&" +
            "".concat(keys.map(genFilterCode).join('&&'), ")return null;"));
      }
      function genFilterCode(key) {
        var keyVal = parseInt(key, 10);
        if (keyVal) {
          return "$event.keyCode!==".concat(keyVal);
        }
        var keyCode = keyCodes[key];
        var keyName = keyNames[key];
        return ("_k($event.keyCode," +
            "".concat(JSON.stringify(key), ",") +
            "".concat(JSON.stringify(keyCode), ",") +
            "$event.key," +
            "".concat(JSON.stringify(keyName)) +
            ")");
      }

      function on(el, dir) {
        if ( true && dir.modifiers) {
          warn$2("v-on without argument does not support modifiers.");
        }
        el.wrapListeners = function (code) { return "_g(".concat(code, ",").concat(dir.value, ")"); };
      }

      function bind(el, dir) {
        el.wrapData = function (code) {
          return "_b(".concat(code, ",'").concat(el.tag, "',").concat(dir.value, ",").concat(dir.modifiers && dir.modifiers.prop ? 'true' : 'false').concat(dir.modifiers && dir.modifiers.sync ? ',true' : '', ")");
        };
      }

      var baseDirectives = {
        on: on,
        bind: bind,
        cloak: noop
      };

      var CodegenState = /** @class */ (function () {
        function CodegenState(options) {
          this.options = options;
          this.warn = options.warn || baseWarn;
          this.transforms = pluckModuleFunction(options.modules, 'transformCode');
          this.dataGenFns = pluckModuleFunction(options.modules, 'genData');
          this.directives = extend(extend({}, baseDirectives), options.directives);
          var isReservedTag = options.isReservedTag || no;
          this.maybeComponent = function (el) {
            return !!el.component || !isReservedTag(el.tag);
          };
          this.onceId = 0;
          this.staticRenderFns = [];
          this.pre = false;
        }
        return CodegenState;
      }());
      function generate(ast, options) {
        var state = new CodegenState(options);
        // fix #11483, Root level <script> tags should not be rendered.
        var code = ast
            ? ast.tag === 'script'
                ? 'null'
                : genElement(ast, state)
            : '_c("div")';
        return {
          render: "with(this){return ".concat(code, "}"),
          staticRenderFns: state.staticRenderFns
        };
      }
      function genElement(el, state) {
        if (el.parent) {
          el.pre = el.pre || el.parent.pre;
        }
        if (el.staticRoot && !el.staticProcessed) {
          return genStatic(el, state);
        }
        else if (el.once && !el.onceProcessed) {
          return genOnce(el, state);
        }
        else if (el.for && !el.forProcessed) {
          return genFor(el, state);
        }
        else if (el.if && !el.ifProcessed) {
          return genIf(el, state);
        }
        else if (el.tag === 'template' && !el.slotTarget && !state.pre) {
          return genChildren(el, state) || 'void 0';
        }
        else if (el.tag === 'slot') {
          return genSlot(el, state);
        }
        else {
          // component or element
          var code = void 0;
          if (el.component) {
            code = genComponent(el.component, el, state);
          }
          else {
            var data = void 0;
            var maybeComponent = state.maybeComponent(el);
            if (!el.plain || (el.pre && maybeComponent)) {
              data = genData(el, state);
            }
            var tag
                // check if this is a component in <script setup>
                = void 0;
            // check if this is a component in <script setup>
            var bindings = state.options.bindings;
            if (maybeComponent && bindings && bindings.__isScriptSetup !== false) {
              tag = checkBindingType(bindings, el.tag);
            }
            if (!tag)
              tag = "'".concat(el.tag, "'");
            var children = el.inlineTemplate ? null : genChildren(el, state, true);
            code = "_c(".concat(tag).concat(data ? ",".concat(data) : '' // data
            ).concat(children ? ",".concat(children) : '' // children
                , ")");
          }
          // module transforms
          for (var i = 0; i < state.transforms.length; i++) {
            code = state.transforms[i](el, code);
          }
          return code;
        }
      }
      function checkBindingType(bindings, key) {
        var camelName = camelize(key);
        var PascalName = capitalize(camelName);
        var checkType = function (type) {
          if (bindings[key] === type) {
            return key;
          }
          if (bindings[camelName] === type) {
            return camelName;
          }
          if (bindings[PascalName] === type) {
            return PascalName;
          }
        };
        var fromConst = checkType("setup-const" /* BindingTypes.SETUP_CONST */) ||
            checkType("setup-reactive-const" /* BindingTypes.SETUP_REACTIVE_CONST */);
        if (fromConst) {
          return fromConst;
        }
        var fromMaybeRef = checkType("setup-let" /* BindingTypes.SETUP_LET */) ||
            checkType("setup-ref" /* BindingTypes.SETUP_REF */) ||
            checkType("setup-maybe-ref" /* BindingTypes.SETUP_MAYBE_REF */);
        if (fromMaybeRef) {
          return fromMaybeRef;
        }
      }
// hoist static sub-trees out
      function genStatic(el, state) {
        el.staticProcessed = true;
        // Some elements (templates) need to behave differently inside of a v-pre
        // node.  All pre nodes are static roots, so we can use this as a location to
        // wrap a state change and reset it upon exiting the pre node.
        var originalPreState = state.pre;
        if (el.pre) {
          state.pre = el.pre;
        }
        state.staticRenderFns.push("with(this){return ".concat(genElement(el, state), "}"));
        state.pre = originalPreState;
        return "_m(".concat(state.staticRenderFns.length - 1).concat(el.staticInFor ? ',true' : '', ")");
      }
// v-once
      function genOnce(el, state) {
        el.onceProcessed = true;
        if (el.if && !el.ifProcessed) {
          return genIf(el, state);
        }
        else if (el.staticInFor) {
          var key = '';
          var parent_1 = el.parent;
          while (parent_1) {
            if (parent_1.for) {
              key = parent_1.key;
              break;
            }
            parent_1 = parent_1.parent;
          }
          if (!key) {
            true &&
            state.warn("v-once can only be used inside v-for that is keyed. ", el.rawAttrsMap['v-once']);
            return genElement(el, state);
          }
          return "_o(".concat(genElement(el, state), ",").concat(state.onceId++, ",").concat(key, ")");
        }
        else {
          return genStatic(el, state);
        }
      }
      function genIf(el, state, altGen, altEmpty) {
        el.ifProcessed = true; // avoid recursion
        return genIfConditions(el.ifConditions.slice(), state, altGen, altEmpty);
      }
      function genIfConditions(conditions, state, altGen, altEmpty) {
        if (!conditions.length) {
          return altEmpty || '_e()';
        }
        var condition = conditions.shift();
        if (condition.exp) {
          return "(".concat(condition.exp, ")?").concat(genTernaryExp(condition.block), ":").concat(genIfConditions(conditions, state, altGen, altEmpty));
        }
        else {
          return "".concat(genTernaryExp(condition.block));
        }
        // v-if with v-once should generate code like (a)?_m(0):_m(1)
        function genTernaryExp(el) {
          return altGen
              ? altGen(el, state)
              : el.once
                  ? genOnce(el, state)
                  : genElement(el, state);
        }
      }
      function genFor(el, state, altGen, altHelper) {
        var exp = el.for;
        var alias = el.alias;
        var iterator1 = el.iterator1 ? ",".concat(el.iterator1) : '';
        var iterator2 = el.iterator2 ? ",".concat(el.iterator2) : '';
        if ( true &&
            state.maybeComponent(el) &&
            el.tag !== 'slot' &&
            el.tag !== 'template' &&
            !el.key) {
          state.warn("<".concat(el.tag, " v-for=\"").concat(alias, " in ").concat(exp, "\">: component lists rendered with ") +
              "v-for should have explicit keys. " +
              "See https://v2.vuejs.org/v2/guide/list.html#key for more info.", el.rawAttrsMap['v-for'], true /* tip */);
        }
        el.forProcessed = true; // avoid recursion
        return ("".concat(altHelper || '_l', "((").concat(exp, "),") +
            "function(".concat(alias).concat(iterator1).concat(iterator2, "){") +
            "return ".concat((altGen || genElement)(el, state)) +
            '})');
      }
      function genData(el, state) {
        var data = '{';
        // directives first.
        // directives may mutate the el's other properties before they are generated.
        var dirs = genDirectives(el, state);
        if (dirs)
          data += dirs + ',';
        // key
        if (el.key) {
          data += "key:".concat(el.key, ",");
        }
        // ref
        if (el.ref) {
          data += "ref:".concat(el.ref, ",");
        }
        if (el.refInFor) {
          data += "refInFor:true,";
        }
        // pre
        if (el.pre) {
          data += "pre:true,";
        }
        // record original tag name for components using "is" attribute
        if (el.component) {
          data += "tag:\"".concat(el.tag, "\",");
        }
        // module data generation functions
        for (var i = 0; i < state.dataGenFns.length; i++) {
          data += state.dataGenFns[i](el);
        }
        // attributes
        if (el.attrs) {
          data += "attrs:".concat(genProps(el.attrs), ",");
        }
        // DOM props
        if (el.props) {
          data += "domProps:".concat(genProps(el.props), ",");
        }
        // event handlers
        if (el.events) {
          data += "".concat(genHandlers(el.events, false), ",");
        }
        if (el.nativeEvents) {
          data += "".concat(genHandlers(el.nativeEvents, true), ",");
        }
        // slot target
        // only for non-scoped slots
        if (el.slotTarget && !el.slotScope) {
          data += "slot:".concat(el.slotTarget, ",");
        }
        // scoped slots
        if (el.scopedSlots) {
          data += "".concat(genScopedSlots(el, el.scopedSlots, state), ",");
        }
        // component v-model
        if (el.model) {
          data += "model:{value:".concat(el.model.value, ",callback:").concat(el.model.callback, ",expression:").concat(el.model.expression, "},");
        }
        // inline-template
        if (el.inlineTemplate) {
          var inlineTemplate = genInlineTemplate(el, state);
          if (inlineTemplate) {
            data += "".concat(inlineTemplate, ",");
          }
        }
        data = data.replace(/,$/, '') + '}';
        // v-bind dynamic argument wrap
        // v-bind with dynamic arguments must be applied using the same v-bind object
        // merge helper so that class/style/mustUseProp attrs are handled correctly.
        if (el.dynamicAttrs) {
          data = "_b(".concat(data, ",\"").concat(el.tag, "\",").concat(genProps(el.dynamicAttrs), ")");
        }
        // v-bind data wrap
        if (el.wrapData) {
          data = el.wrapData(data);
        }
        // v-on data wrap
        if (el.wrapListeners) {
          data = el.wrapListeners(data);
        }
        return data;
      }
      function genDirectives(el, state) {
        var dirs = el.directives;
        if (!dirs)
          return;
        var res = 'directives:[';
        var hasRuntime = false;
        var i, l, dir, needRuntime;
        for (i = 0, l = dirs.length; i < l; i++) {
          dir = dirs[i];
          needRuntime = true;
          var gen = state.directives[dir.name];
          if (gen) {
            // compile-time directive that manipulates AST.
            // returns true if it also needs a runtime counterpart.
            needRuntime = !!gen(el, dir, state.warn);
          }
          if (needRuntime) {
            hasRuntime = true;
            res += "{name:\"".concat(dir.name, "\",rawName:\"").concat(dir.rawName, "\"").concat(dir.value
                ? ",value:(".concat(dir.value, "),expression:").concat(JSON.stringify(dir.value))
                : '').concat(dir.arg ? ",arg:".concat(dir.isDynamicArg ? dir.arg : "\"".concat(dir.arg, "\"")) : '').concat(dir.modifiers ? ",modifiers:".concat(JSON.stringify(dir.modifiers)) : '', "},");
          }
        }
        if (hasRuntime) {
          return res.slice(0, -1) + ']';
        }
      }
      function genInlineTemplate(el, state) {
        var ast = el.children[0];
        if ( true && (el.children.length !== 1 || ast.type !== 1)) {
          state.warn('Inline-template components must have exactly one child element.', { start: el.start });
        }
        if (ast && ast.type === 1) {
          var inlineRenderFns = generate(ast, state.options);
          return "inlineTemplate:{render:function(){".concat(inlineRenderFns.render, "},staticRenderFns:[").concat(inlineRenderFns.staticRenderFns
              .map(function (code) { return "function(){".concat(code, "}"); })
              .join(','), "]}");
        }
      }
      function genScopedSlots(el, slots, state) {
        // by default scoped slots are considered "stable", this allows child
        // components with only scoped slots to skip forced updates from parent.
        // but in some cases we have to bail-out of this optimization
        // for example if the slot contains dynamic names, has v-if or v-for on them...
        var needsForceUpdate = el.for ||
            Object.keys(slots).some(function (key) {
              var slot = slots[key];
              return (slot.slotTargetDynamic || slot.if || slot.for || containsSlotChild(slot) // is passing down slot from parent which may be dynamic
              );
            });
        // #9534: if a component with scoped slots is inside a conditional branch,
        // it's possible for the same component to be reused but with different
        // compiled slot content. To avoid that, we generate a unique key based on
        // the generated code of all the slot contents.
        var needsKey = !!el.if;
        // OR when it is inside another scoped slot or v-for (the reactivity may be
        // disconnected due to the intermediate scope variable)
        // #9438, #9506
        // TODO: this can be further optimized by properly analyzing in-scope bindings
        // and skip force updating ones that do not actually use scope variables.
        if (!needsForceUpdate) {
          var parent_2 = el.parent;
          while (parent_2) {
            if ((parent_2.slotScope && parent_2.slotScope !== emptySlotScopeToken) ||
                parent_2.for) {
              needsForceUpdate = true;
              break;
            }
            if (parent_2.if) {
              needsKey = true;
            }
            parent_2 = parent_2.parent;
          }
        }
        var generatedSlots = Object.keys(slots)
            .map(function (key) { return genScopedSlot(slots[key], state); })
            .join(',');
        return "scopedSlots:_u([".concat(generatedSlots, "]").concat(needsForceUpdate ? ",null,true" : "").concat(!needsForceUpdate && needsKey ? ",null,false,".concat(hash(generatedSlots)) : "", ")");
      }
      function hash(str) {
        var hash = 5381;
        var i = str.length;
        while (i) {
          hash = (hash * 33) ^ str.charCodeAt(--i);
        }
        return hash >>> 0;
      }
      function containsSlotChild(el) {
        if (el.type === 1) {
          if (el.tag === 'slot') {
            return true;
          }
          return el.children.some(containsSlotChild);
        }
        return false;
      }
      function genScopedSlot(el, state) {
        var isLegacySyntax = el.attrsMap['slot-scope'];
        if (el.if && !el.ifProcessed && !isLegacySyntax) {
          return genIf(el, state, genScopedSlot, "null");
        }
        if (el.for && !el.forProcessed) {
          return genFor(el, state, genScopedSlot);
        }
        var slotScope = el.slotScope === emptySlotScopeToken ? "" : String(el.slotScope);
        var fn = "function(".concat(slotScope, "){") +
            "return ".concat(el.tag === 'template'
                ? el.if && isLegacySyntax
                    ? "(".concat(el.if, ")?").concat(genChildren(el, state) || 'undefined', ":undefined")
                    : genChildren(el, state) || 'undefined'
                : genElement(el, state), "}");
        // reverse proxy v-slot without scope on this.$slots
        var reverseProxy = slotScope ? "" : ",proxy:true";
        return "{key:".concat(el.slotTarget || "\"default\"", ",fn:").concat(fn).concat(reverseProxy, "}");
      }
      function genChildren(el, state, checkSkip, altGenElement, altGenNode) {
        var children = el.children;
        if (children.length) {
          var el_1 = children[0];
          // optimize single v-for
          if (children.length === 1 &&
              el_1.for &&
              el_1.tag !== 'template' &&
              el_1.tag !== 'slot') {
            var normalizationType_1 = checkSkip
                ? state.maybeComponent(el_1)
                    ? ",1"
                    : ",0"
                : "";
            return "".concat((altGenElement || genElement)(el_1, state)).concat(normalizationType_1);
          }
          var normalizationType = checkSkip
              ? getNormalizationType(children, state.maybeComponent)
              : 0;
          var gen_1 = altGenNode || genNode;
          return "[".concat(children.map(function (c) { return gen_1(c, state); }).join(','), "]").concat(normalizationType ? ",".concat(normalizationType) : '');
        }
      }
// determine the normalization needed for the children array.
// 0: no normalization needed
// 1: simple normalization needed (possible 1-level deep nested array)
// 2: full normalization needed
      function getNormalizationType(children, maybeComponent) {
        var res = 0;
        for (var i = 0; i < children.length; i++) {
          var el = children[i];
          if (el.type !== 1) {
            continue;
          }
          if (needsNormalization(el) ||
              (el.ifConditions &&
                  el.ifConditions.some(function (c) { return needsNormalization(c.block); }))) {
            res = 2;
            break;
          }
          if (maybeComponent(el) ||
              (el.ifConditions && el.ifConditions.some(function (c) { return maybeComponent(c.block); }))) {
            res = 1;
          }
        }
        return res;
      }
      function needsNormalization(el) {
        return el.for !== undefined || el.tag === 'template' || el.tag === 'slot';
      }
      function genNode(node, state) {
        if (node.type === 1) {
          return genElement(node, state);
        }
        else if (node.type === 3 && node.isComment) {
          return genComment(node);
        }
        else {
          return genText(node);
        }
      }
      function genText(text) {
        return "_v(".concat(text.type === 2
            ? text.expression // no need for () because already wrapped in _s()
            : transformSpecialNewlines(JSON.stringify(text.text)), ")");
      }
      function genComment(comment) {
        return "_e(".concat(JSON.stringify(comment.text), ")");
      }
      function genSlot(el, state) {
        var slotName = el.slotName || '"default"';
        var children = genChildren(el, state);
        var res = "_t(".concat(slotName).concat(children ? ",function(){return ".concat(children, "}") : '');
        var attrs = el.attrs || el.dynamicAttrs
            ? genProps((el.attrs || []).concat(el.dynamicAttrs || []).map(function (attr) { return ({
              // slot props are camelized
              name: camelize(attr.name),
              value: attr.value,
              dynamic: attr.dynamic
            }); }))
            : null;
        var bind = el.attrsMap['v-bind'];
        if ((attrs || bind) && !children) {
          res += ",null";
        }
        if (attrs) {
          res += ",".concat(attrs);
        }
        if (bind) {
          res += "".concat(attrs ? '' : ',null', ",").concat(bind);
        }
        return res + ')';
      }
// componentName is el.component, take it as argument to shun flow's pessimistic refinement
      function genComponent(componentName, el, state) {
        var children = el.inlineTemplate ? null : genChildren(el, state, true);
        return "_c(".concat(componentName, ",").concat(genData(el, state)).concat(children ? ",".concat(children) : '', ")");
      }
      function genProps(props) {
        var staticProps = "";
        var dynamicProps = "";
        for (var i = 0; i < props.length; i++) {
          var prop = props[i];
          var value = transformSpecialNewlines(prop.value);
          if (prop.dynamic) {
            dynamicProps += "".concat(prop.name, ",").concat(value, ",");
          }
          else {
            staticProps += "\"".concat(prop.name, "\":").concat(value, ",");
          }
        }
        staticProps = "{".concat(staticProps.slice(0, -1), "}");
        if (dynamicProps) {
          return "_d(".concat(staticProps, ",[").concat(dynamicProps.slice(0, -1), "])");
        }
        else {
          return staticProps;
        }
      }
// #3895, #4268
      function transformSpecialNewlines(text) {
        return text.replace(/\u2028/g, '\\u2028').replace(/\u2029/g, '\\u2029');
      }

// these keywords should not appear inside expressions, but operators like
// typeof, instanceof and in are allowed
      var prohibitedKeywordRE = new RegExp('\\b' +
          ('do,if,for,let,new,try,var,case,else,with,await,break,catch,class,const,' +
              'super,throw,while,yield,delete,export,import,return,switch,default,' +
              'extends,finally,continue,debugger,function,arguments')
              .split(',')
              .join('\\b|\\b') +
          '\\b');
// these unary operators should not be used as property/method names
      var unaryOperatorsRE = new RegExp('\\b' +
          'delete,typeof,void'.split(',').join('\\s*\\([^\\)]*\\)|\\b') +
          '\\s*\\([^\\)]*\\)');
// strip strings in expressions
      var stripStringRE = /'(?:[^'\\]|\\.)*'|"(?:[^"\\]|\\.)*"|`(?:[^`\\]|\\.)*\$\{|\}(?:[^`\\]|\\.)*`|`(?:[^`\\]|\\.)*`/g;
// detect problematic expressions in a template
      function detectErrors(ast, warn) {
        if (ast) {
          checkNode(ast, warn);
        }
      }
      function checkNode(node, warn) {
        if (node.type === 1) {
          for (var name_1 in node.attrsMap) {
            if (dirRE.test(name_1)) {
              var value = node.attrsMap[name_1];
              if (value) {
                var range = node.rawAttrsMap[name_1];
                if (name_1 === 'v-for') {
                  checkFor(node, "v-for=\"".concat(value, "\""), warn, range);
                }
                else if (name_1 === 'v-slot' || name_1[0] === '#') {
                  checkFunctionParameterExpression(value, "".concat(name_1, "=\"").concat(value, "\""), warn, range);
                }
                else if (onRE.test(name_1)) {
                  checkEvent(value, "".concat(name_1, "=\"").concat(value, "\""), warn, range);
                }
                else {
                  checkExpression(value, "".concat(name_1, "=\"").concat(value, "\""), warn, range);
                }
              }
            }
          }
          if (node.children) {
            for (var i = 0; i < node.children.length; i++) {
              checkNode(node.children[i], warn);
            }
          }
        }
        else if (node.type === 2) {
          checkExpression(node.expression, node.text, warn, node);
        }
      }
      function checkEvent(exp, text, warn, range) {
        var stripped = exp.replace(stripStringRE, '');
        var keywordMatch = stripped.match(unaryOperatorsRE);
        if (keywordMatch && stripped.charAt(keywordMatch.index - 1) !== '$') {
          warn("avoid using JavaScript unary operator as property name: " +
              "\"".concat(keywordMatch[0], "\" in expression ").concat(text.trim()), range);
        }
        checkExpression(exp, text, warn, range);
      }
      function checkFor(node, text, warn, range) {
        checkExpression(node.for || '', text, warn, range);
        checkIdentifier(node.alias, 'v-for alias', text, warn, range);
        checkIdentifier(node.iterator1, 'v-for iterator', text, warn, range);
        checkIdentifier(node.iterator2, 'v-for iterator', text, warn, range);
      }
      function checkIdentifier(ident, type, text, warn, range) {
        if (typeof ident === 'string') {
          try {
            new Function("var ".concat(ident, "=_"));
          }
          catch (e) {
            warn("invalid ".concat(type, " \"").concat(ident, "\" in expression: ").concat(text.trim()), range);
          }
        }
      }
      function checkExpression(exp, text, warn, range) {
        try {
          new Function("return ".concat(exp));
        }
        catch (e) {
          var keywordMatch = exp
              .replace(stripStringRE, '')
              .match(prohibitedKeywordRE);
          if (keywordMatch) {
            warn("avoid using JavaScript keyword as property name: " +
                "\"".concat(keywordMatch[0], "\"\n  Raw expression: ").concat(text.trim()), range);
          }
          else {
            warn("invalid expression: ".concat(e.message, " in\n\n") +
                "    ".concat(exp, "\n\n") +
                "  Raw expression: ".concat(text.trim(), "\n"), range);
          }
        }
      }
      function checkFunctionParameterExpression(exp, text, warn, range) {
        try {
          new Function(exp, '');
        }
        catch (e) {
          warn("invalid function parameter expression: ".concat(e.message, " in\n\n") +
              "    ".concat(exp, "\n\n") +
              "  Raw expression: ".concat(text.trim(), "\n"), range);
        }
      }

      var range = 2;
      function generateCodeFrame(source, start, end) {
        if (start === void 0) { start = 0; }
        if (end === void 0) { end = source.length; }
        var lines = source.split(/\r?\n/);
        var count = 0;
        var res = [];
        for (var i = 0; i < lines.length; i++) {
          count += lines[i].length + 1;
          if (count >= start) {
            for (var j = i - range; j <= i + range || end > count; j++) {
              if (j < 0 || j >= lines.length)
                continue;
              res.push("".concat(j + 1).concat(repeat(" ", 3 - String(j + 1).length), "|  ").concat(lines[j]));
              var lineLength = lines[j].length;
              if (j === i) {
                // push underline
                var pad = start - (count - lineLength) + 1;
                var length_1 = end > count ? lineLength - pad : end - start;
                res.push("   |  " + repeat(" ", pad) + repeat("^", length_1));
              }
              else if (j > i) {
                if (end > count) {
                  var length_2 = Math.min(end - count, lineLength);
                  res.push("   |  " + repeat("^", length_2));
                }
                count += lineLength + 1;
              }
            }
            break;
          }
        }
        return res.join('\n');
      }
      function repeat(str, n) {
        var result = '';
        if (n > 0) {
          // eslint-disable-next-line no-constant-condition
          while (true) {
            // eslint-disable-line
            if (n & 1)
              result += str;
            n >>>= 1;
            if (n <= 0)
              break;
            str += str;
          }
        }
        return result;
      }

      function createFunction(code, errors) {
        try {
          return new Function(code);
        }
        catch (err) {
          errors.push({ err: err, code: code });
          return noop;
        }
      }
      function createCompileToFunctionFn(compile) {
        var cache = Object.create(null);
        return function compileToFunctions(template, options, vm) {
          options = extend({}, options);
          var warn = options.warn || warn$2;
          delete options.warn;
          /* istanbul ignore if */
          if (true) {
            // detect possible CSP restriction
            try {
              new Function('return 1');
            }
            catch (e) {
              if (e.toString().match(/unsafe-eval|CSP/)) {
                warn('It seems you are using the standalone build of Vue.js in an ' +
                    'environment with Content Security Policy that prohibits unsafe-eval. ' +
                    'The template compiler cannot work in this environment. Consider ' +
                    'relaxing the policy to allow unsafe-eval or pre-compiling your ' +
                    'templates into render functions.');
              }
            }
          }
          // check cache
          var key = options.delimiters
              ? String(options.delimiters) + template
              : template;
          if (cache[key]) {
            return cache[key];
          }
          // compile
          var compiled = compile(template, options);
          // check compilation errors/tips
          if (true) {
            if (compiled.errors && compiled.errors.length) {
              if (options.outputSourceRange) {
                compiled.errors.forEach(function (e) {
                  warn("Error compiling template:\n\n".concat(e.msg, "\n\n") +
                      generateCodeFrame(template, e.start, e.end), vm);
                });
              }
              else {
                warn("Error compiling template:\n\n".concat(template, "\n\n") +
                    compiled.errors.map(function (e) { return "- ".concat(e); }).join('\n') +
                    '\n', vm);
              }
            }
            if (compiled.tips && compiled.tips.length) {
              if (options.outputSourceRange) {
                compiled.tips.forEach(function (e) { return tip(e.msg, vm); });
              }
              else {
                compiled.tips.forEach(function (msg) { return tip(msg, vm); });
              }
            }
          }
          // turn code into functions
          var res = {};
          var fnGenErrors = [];
          res.render = createFunction(compiled.render, fnGenErrors);
          res.staticRenderFns = compiled.staticRenderFns.map(function (code) {
            return createFunction(code, fnGenErrors);
          });
          // check function generation errors.
          // this should only happen if there is a bug in the compiler itself.
          // mostly for codegen development use
          /* istanbul ignore if */
          if (true) {
            if ((!compiled.errors || !compiled.errors.length) && fnGenErrors.length) {
              warn("Failed to generate render function:\n\n" +
                  fnGenErrors
                      .map(function (_a) {
                        var err = _a.err, code = _a.code;
                        return "".concat(err.toString(), " in\n\n").concat(code, "\n");
                      })
                      .join('\n'), vm);
            }
          }
          return (cache[key] = res);
        };
      }

      function createCompilerCreator(baseCompile) {
        return function createCompiler(baseOptions) {
          function compile(template, options) {
            var finalOptions = Object.create(baseOptions);
            var errors = [];
            var tips = [];
            var warn = function (msg, range, tip) {
              (tip ? tips : errors).push(msg);
            };
            if (options) {
              if ( true && options.outputSourceRange) {
                // $flow-disable-line
                var leadingSpaceLength_1 = template.match(/^\s*/)[0].length;
                warn = function (msg, range, tip) {
                  var data = typeof msg === 'string' ? { msg: msg } : msg;
                  if (range) {
                    if (range.start != null) {
                      data.start = range.start + leadingSpaceLength_1;
                    }
                    if (range.end != null) {
                      data.end = range.end + leadingSpaceLength_1;
                    }
                  }
                  (tip ? tips : errors).push(data);
                };
              }
              // merge custom modules
              if (options.modules) {
                finalOptions.modules = (baseOptions.modules || []).concat(options.modules);
              }
              // merge custom directives
              if (options.directives) {
                finalOptions.directives = extend(Object.create(baseOptions.directives || null), options.directives);
              }
              // copy other options
              for (var key in options) {
                if (key !== 'modules' && key !== 'directives') {
                  finalOptions[key] = options[key];
                }
              }
            }
            finalOptions.warn = warn;
            var compiled = baseCompile(template.trim(), finalOptions);
            if (true) {
              detectErrors(compiled.ast, warn);
            }
            compiled.errors = errors;
            compiled.tips = tips;
            return compiled;
          }
          return {
            compile: compile,
            compileToFunctions: createCompileToFunctionFn(compile)
          };
        };
      }

// `createCompilerCreator` allows creating compilers that use alternative
// parser/optimizer/codegen, e.g the SSR optimizing compiler.
// Here we just export a default compiler using the default parts.
      var createCompiler = createCompilerCreator(function baseCompile(template, options) {
        var ast = parse(template.trim(), options);
        if (options.optimize !== false) {
          optimize(ast, options);
        }
        var code = generate(ast, options);
        return {
          ast: ast,
          render: code.render,
          staticRenderFns: code.staticRenderFns
        };
      });

      var _a = createCompiler(baseOptions), compileToFunctions = _a.compileToFunctions;

// check whether current browser encodes a char inside attribute values
      var div;
      function getShouldDecode(href) {
        div = div || document.createElement('div');
        div.innerHTML = href ? "<a href=\"\n\"/>" : "<div a=\"\n\"/>";
        return div.innerHTML.indexOf('&#10;') > 0;
      }
// #3663: IE encodes newlines inside attribute values while other browsers don't
      var shouldDecodeNewlines = inBrowser ? getShouldDecode(false) : false;
// #6828: chrome encodes content in a[href]
      var shouldDecodeNewlinesForHref = inBrowser
          ? getShouldDecode(true)
          : false;

      var idToTemplate = cached(function (id) {
        var el = query(id);
        return el && el.innerHTML;
      });
      var mount = Vue.prototype.$mount;
      Vue.prototype.$mount = function (el, hydrating) {
        el = el && query(el);
        /* istanbul ignore if */
        if (el === document.body || el === document.documentElement) {
          true &&
          warn$2("Do not mount Vue to <html> or <body> - mount to normal elements instead.");
          return this;
        }
        var options = this.$options;
        // resolve template/el and convert to render function
        if (!options.render) {
          var template = options.template;
          if (template) {
            if (typeof template === 'string') {
              if (template.charAt(0) === '#') {
                template = idToTemplate(template);
                /* istanbul ignore if */
                if ( true && !template) {
                  warn$2("Template element not found or is empty: ".concat(options.template), this);
                }
              }
            }
            else if (template.nodeType) {
              template = template.innerHTML;
            }
            else {
              if (true) {
                warn$2('invalid template option:' + template, this);
              }
              return this;
            }
          }
          else if (el) {
            // @ts-expect-error
            template = getOuterHTML(el);
          }
          if (template) {
            /* istanbul ignore if */
            if ( true && config.performance && mark) {
              mark('compile');
            }
            var _a = compileToFunctions(template, {
              outputSourceRange: "development" !== 'production',
              shouldDecodeNewlines: shouldDecodeNewlines,
              shouldDecodeNewlinesForHref: shouldDecodeNewlinesForHref,
              delimiters: options.delimiters,
              comments: options.comments
            }, this), render = _a.render, staticRenderFns = _a.staticRenderFns;
            options.render = render;
            options.staticRenderFns = staticRenderFns;
            /* istanbul ignore if */
            if ( true && config.performance && mark) {
              mark('compile end');
              measure("vue ".concat(this._name, " compile"), 'compile', 'compile end');
            }
          }
        }
        return mount.call(this, el, hydrating);
      };
      /**
       * Get outerHTML of elements, taking care
       * of SVG elements in IE as well.
       */
      function getOuterHTML(el) {
        if (el.outerHTML) {
          return el.outerHTML;
        }
        else {
          var container = document.createElement('div');
          container.appendChild(el.cloneNode(true));
          return container.innerHTML;
        }
      }
      Vue.compile = compileToFunctions;




      /***/ }),

    /***/ "./node_modules/axios/package.json":
    /*!*****************************************!*\
  !*** ./node_modules/axios/package.json ***!
  \*****************************************/
    /***/ ((module) => {

      "use strict";
      module.exports = JSON.parse('{"name":"axios","version":"0.21.4","description":"Promise based HTTP client for the browser and node.js","main":"index.js","scripts":{"test":"grunt test","start":"node ./sandbox/server.js","build":"NODE_ENV=production grunt build","preversion":"npm test","version":"npm run build && grunt version && git add -A dist && git add CHANGELOG.md bower.json package.json","postversion":"git push && git push --tags","examples":"node ./examples/server.js","coveralls":"cat coverage/lcov.info | ./node_modules/coveralls/bin/coveralls.js","fix":"eslint --fix lib/**/*.js"},"repository":{"type":"git","url":"https://github.com/axios/axios.git"},"keywords":["xhr","http","ajax","promise","node"],"author":"Matt Zabriskie","license":"MIT","bugs":{"url":"https://github.com/axios/axios/issues"},"homepage":"https://axios-http.com","devDependencies":{"coveralls":"^3.0.0","es6-promise":"^4.2.4","grunt":"^1.3.0","grunt-banner":"^0.6.0","grunt-cli":"^1.2.0","grunt-contrib-clean":"^1.1.0","grunt-contrib-watch":"^1.0.0","grunt-eslint":"^23.0.0","grunt-karma":"^4.0.0","grunt-mocha-test":"^0.13.3","grunt-ts":"^6.0.0-beta.19","grunt-webpack":"^4.0.2","istanbul-instrumenter-loader":"^1.0.0","jasmine-core":"^2.4.1","karma":"^6.3.2","karma-chrome-launcher":"^3.1.0","karma-firefox-launcher":"^2.1.0","karma-jasmine":"^1.1.1","karma-jasmine-ajax":"^0.1.13","karma-safari-launcher":"^1.0.0","karma-sauce-launcher":"^4.3.6","karma-sinon":"^1.0.5","karma-sourcemap-loader":"^0.3.8","karma-webpack":"^4.0.2","load-grunt-tasks":"^3.5.2","minimist":"^1.2.0","mocha":"^8.2.1","sinon":"^4.5.0","terser-webpack-plugin":"^4.2.3","typescript":"^4.0.5","url-search-params":"^0.10.0","webpack":"^4.44.2","webpack-dev-server":"^3.11.0"},"browser":{"./lib/adapters/http.js":"./lib/adapters/xhr.js"},"jsdelivr":"dist/axios.min.js","unpkg":"dist/axios.min.js","typings":"./index.d.ts","dependencies":{"follow-redirects":"^1.14.0"},"bundlesize":[{"path":"./dist/axios.min.js","threshold":"5kB"}]}');

      /***/ })

    /******/ 	});
  /************************************************************************/
  /******/ 	// The module cache
  /******/ 	var __webpack_module_cache__ = {};
  /******/
  /******/ 	// The require function
  /******/ 	function __webpack_require__(moduleId) {
    /******/ 		// Check if module is in cache
    /******/ 		var cachedModule = __webpack_module_cache__[moduleId];
    /******/ 		if (cachedModule !== undefined) {
      /******/ 			return cachedModule.exports;
      /******/ 		}
    /******/ 		// Create a new module (and put it into the cache)
    /******/ 		var module = __webpack_module_cache__[moduleId] = {
      /******/ 			// no module.id needed
      /******/ 			// no module.loaded needed
      /******/ 			exports: {}
      /******/ 		};
    /******/
    /******/ 		// Execute the module function
    /******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
    /******/
    /******/ 		// Return the exports of the module
    /******/ 		return module.exports;
    /******/ 	}
  /******/
  /******/ 	// expose the modules object (__webpack_modules__)
  /******/ 	__webpack_require__.m = __webpack_modules__;
  /******/
  /************************************************************************/
  /******/ 	/* webpack/runtime/chunk loaded */
  /******/ 	(() => {
    /******/ 		var deferred = [];
    /******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
      /******/ 			if(chunkIds) {
        /******/ 				priority = priority || 0;
        /******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
        /******/ 				deferred[i] = [chunkIds, fn, priority];
        /******/ 				return;
        /******/ 			}
      /******/ 			var notFulfilled = Infinity;
      /******/ 			for (var i = 0; i < deferred.length; i++) {
        /******/ 				var [chunkIds, fn, priority] = deferred[i];
        /******/ 				var fulfilled = true;
        /******/ 				for (var j = 0; j < chunkIds.length; j++) {
          /******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
            /******/ 						chunkIds.splice(j--, 1);
            /******/ 					} else {
            /******/ 						fulfilled = false;
            /******/ 						if(priority < notFulfilled) notFulfilled = priority;
            /******/ 					}
          /******/ 				}
        /******/ 				if(fulfilled) {
          /******/ 					deferred.splice(i--, 1)
          /******/ 					var r = fn();
          /******/ 					if (r !== undefined) result = r;
          /******/ 				}
        /******/ 			}
      /******/ 			return result;
      /******/ 		};
    /******/ 	})();
  /******/
  /******/ 	/* webpack/runtime/compat get default export */
  /******/ 	(() => {
    /******/ 		// getDefaultExport function for compatibility with non-harmony modules
    /******/ 		__webpack_require__.n = (module) => {
      /******/ 			var getter = module && module.__esModule ?
          /******/ 				() => (module['default']) :
          /******/ 				() => (module);
      /******/ 			__webpack_require__.d(getter, { a: getter });
      /******/ 			return getter;
      /******/ 		};
    /******/ 	})();
  /******/
  /******/ 	/* webpack/runtime/define property getters */
  /******/ 	(() => {
    /******/ 		// define getter functions for harmony exports
    /******/ 		__webpack_require__.d = (exports, definition) => {
      /******/ 			for(var key in definition) {
        /******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
          /******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
          /******/ 				}
        /******/ 			}
      /******/ 		};
    /******/ 	})();
  /******/
  /******/ 	/* webpack/runtime/ensure chunk */
  /******/ 	(() => {
    /******/ 		__webpack_require__.f = {};
    /******/ 		// This file contains only the entry chunk.
    /******/ 		// The chunk loading function for additional chunks
    /******/ 		__webpack_require__.e = (chunkId) => {
      /******/ 			return Promise.all(Object.keys(__webpack_require__.f).reduce((promises, key) => {
        /******/ 				__webpack_require__.f[key](chunkId, promises);
        /******/ 				return promises;
        /******/ 			}, []));
      /******/ 		};
    /******/ 	})();
  /******/
  /******/ 	/* webpack/runtime/get javascript chunk filename */
  /******/ 	(() => {
    /******/ 		// This function allow to reference async chunks
    /******/ 		__webpack_require__.u = (chunkId) => {
      /******/ 			// return url for filenames not based on template
      /******/ 			if (chunkId === "resources_js_components_items_index_vue") return "js/" + chunkId + ".js";
      /******/ 			// return url for filenames based on template
      /******/ 			return undefined;
      /******/ 		};
    /******/ 	})();
  /******/
  /******/ 	/* webpack/runtime/get mini-css chunk filename */
  /******/ 	(() => {
    /******/ 		// This function allow to reference all chunks
    /******/ 		__webpack_require__.miniCssF = (chunkId) => {
      /******/ 			// return url for filenames based on template
      /******/ 			return "" + chunkId + ".css";
      /******/ 		};
    /******/ 	})();
  /******/
  /******/ 	/* webpack/runtime/global */
  /******/ 	(() => {
    /******/ 		__webpack_require__.g = (function() {
      /******/ 			if (typeof globalThis === 'object') return globalThis;
      /******/ 			try {
        /******/ 				return this || new Function('return this')();
        /******/ 			} catch (e) {
        /******/ 				if (typeof window === 'object') return window;
        /******/ 			}
      /******/ 		})();
    /******/ 	})();
  /******/
  /******/ 	/* webpack/runtime/hasOwnProperty shorthand */
  /******/ 	(() => {
    /******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
    /******/ 	})();
  /******/
  /******/ 	/* webpack/runtime/load script */
  /******/ 	(() => {
    /******/ 		var inProgress = {};
    /******/ 		// data-webpack is not used as build has no uniqueName
    /******/ 		// loadScript function to load a script via script tag
    /******/ 		__webpack_require__.l = (url, done, key, chunkId) => {
      /******/ 			if(inProgress[url]) { inProgress[url].push(done); return; }
      /******/ 			var script, needAttach;
      /******/ 			if(key !== undefined) {
        /******/ 				var scripts = document.getElementsByTagName("script");
        /******/ 				for(var i = 0; i < scripts.length; i++) {
          /******/ 					var s = scripts[i];
          /******/ 					if(s.getAttribute("src") == url) { script = s; break; }
          /******/ 				}
        /******/ 			}
      /******/ 			if(!script) {
        /******/ 				needAttach = true;
        /******/ 				script = document.createElement('script');
        /******/
        /******/ 				script.charset = 'utf-8';
        /******/ 				script.timeout = 120;
        /******/ 				if (__webpack_require__.nc) {
          /******/ 					script.setAttribute("nonce", __webpack_require__.nc);
          /******/ 				}
        /******/
        /******/ 				script.src = url;
        /******/ 			}
      /******/ 			inProgress[url] = [done];
      /******/ 			var onScriptComplete = (prev, event) => {
        /******/ 				// avoid mem leaks in IE.
        /******/ 				script.onerror = script.onload = null;
        /******/ 				clearTimeout(timeout);
        /******/ 				var doneFns = inProgress[url];
        /******/ 				delete inProgress[url];
        /******/ 				script.parentNode && script.parentNode.removeChild(script);
        /******/ 				doneFns && doneFns.forEach((fn) => (fn(event)));
        /******/ 				if(prev) return prev(event);
        /******/ 			};
      /******/ 			var timeout = setTimeout(onScriptComplete.bind(null, undefined, { type: 'timeout', target: script }), 120000);
      /******/ 			script.onerror = onScriptComplete.bind(null, script.onerror);
      /******/ 			script.onload = onScriptComplete.bind(null, script.onload);
      /******/ 			needAttach && document.head.appendChild(script);
      /******/ 		};
    /******/ 	})();
  /******/
  /******/ 	/* webpack/runtime/make namespace object */
  /******/ 	(() => {
    /******/ 		// define __esModule on exports
    /******/ 		__webpack_require__.r = (exports) => {
      /******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
        /******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
        /******/ 			}
      /******/ 			Object.defineProperty(exports, '__esModule', { value: true });
      /******/ 		};
    /******/ 	})();
  /******/
  /******/ 	/* webpack/runtime/publicPath */
  /******/ 	(() => {
    /******/ 		__webpack_require__.p = "/";
    /******/ 	})();
  /******/
  /******/ 	/* webpack/runtime/jsonp chunk loading */
  /******/ 	(() => {
    /******/ 		// no baseURI
    /******/
    /******/ 		// object to store loaded and loading chunks
    /******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
    /******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
    /******/ 		var installedChunks = {
      /******/ 			"/js/app": 0,
      /******/ 			"css/app": 0
      /******/ 		};
    /******/
    /******/ 		__webpack_require__.f.j = (chunkId, promises) => {
      /******/ 				// JSONP chunk loading for javascript
      /******/ 				var installedChunkData = __webpack_require__.o(installedChunks, chunkId) ? installedChunks[chunkId] : undefined;
      /******/ 				if(installedChunkData !== 0) { // 0 means "already installed".
        /******/
        /******/ 					// a Promise means "currently loading".
        /******/ 					if(installedChunkData) {
          /******/ 						promises.push(installedChunkData[2]);
          /******/ 					} else {
          /******/ 						if("css/app" != chunkId) {
            /******/ 							// setup Promise in chunk cache
            /******/ 							var promise = new Promise((resolve, reject) => (installedChunkData = installedChunks[chunkId] = [resolve, reject]));
            /******/ 							promises.push(installedChunkData[2] = promise);
            /******/
            /******/ 							// start chunk loading
            /******/ 							var url = __webpack_require__.p + __webpack_require__.u(chunkId);
            /******/ 							// create error before stack unwound to get useful stacktrace later
            /******/ 							var error = new Error();
            /******/ 							var loadingEnded = (event) => {
              /******/ 								if(__webpack_require__.o(installedChunks, chunkId)) {
                /******/ 									installedChunkData = installedChunks[chunkId];
                /******/ 									if(installedChunkData !== 0) installedChunks[chunkId] = undefined;
                /******/ 									if(installedChunkData) {
                  /******/ 										var errorType = event && (event.type === 'load' ? 'missing' : event.type);
                  /******/ 										var realSrc = event && event.target && event.target.src;
                  /******/ 										error.message = 'Loading chunk ' + chunkId + ' failed.\n(' + errorType + ': ' + realSrc + ')';
                  /******/ 										error.name = 'ChunkLoadError';
                  /******/ 										error.type = errorType;
                  /******/ 										error.request = realSrc;
                  /******/ 										installedChunkData[1](error);
                  /******/ 									}
                /******/ 								}
              /******/ 							};
            /******/ 							__webpack_require__.l(url, loadingEnded, "chunk-" + chunkId, chunkId);
            /******/ 						} else installedChunks[chunkId] = 0;
          /******/ 					}
        /******/ 				}
      /******/ 		};
    /******/
    /******/ 		// no prefetching
    /******/
    /******/ 		// no preloaded
    /******/
    /******/ 		// no HMR
    /******/
    /******/ 		// no HMR manifest
    /******/
    /******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
    /******/
    /******/ 		// install a JSONP callback for chunk loading
    /******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
      /******/ 			var [chunkIds, moreModules, runtime] = data;
      /******/ 			// add "moreModules" to the modules object,
      /******/ 			// then flag all "chunkIds" as loaded and fire callback
      /******/ 			var moduleId, chunkId, i = 0;
      /******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
        /******/ 				for(moduleId in moreModules) {
          /******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
            /******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
            /******/ 					}
          /******/ 				}
        /******/ 				if(runtime) var result = runtime(__webpack_require__);
        /******/ 			}
      /******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
      /******/ 			for(;i < chunkIds.length; i++) {
        /******/ 				chunkId = chunkIds[i];
        /******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
          /******/ 					installedChunks[chunkId][0]();
          /******/ 				}
        /******/ 				installedChunks[chunkId] = 0;
        /******/ 			}
      /******/ 			return __webpack_require__.O(result);
      /******/ 		}
    /******/
    /******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
    /******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
    /******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
    /******/ 	})();
  /******/
  /************************************************************************/
  /******/
  /******/ 	// startup
  /******/ 	// Load entry module and return exports
  /******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
  /******/ 	__webpack_require__.O(undefined, ["css/app"], () => (__webpack_require__("./resources/js/app.js")))
  /******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/app"], () => (__webpack_require__("./resources/sass/app.scss")))
  /******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
  /******/
  /******/ })()
;
