import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Administration\Auth\LoginController::form
 * @see app/Http/Controllers/Administration/Auth/LoginController.php:16
 * @route '/access-administration/auth/login'
 */
export const form = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: form.url(options),
    method: 'get',
})

form.definition = {
    methods: ["get","head"],
    url: '/access-administration/auth/login',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Administration\Auth\LoginController::form
 * @see app/Http/Controllers/Administration/Auth/LoginController.php:16
 * @route '/access-administration/auth/login'
 */
form.url = (options?: RouteQueryOptions) => {
    return form.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Administration\Auth\LoginController::form
 * @see app/Http/Controllers/Administration/Auth/LoginController.php:16
 * @route '/access-administration/auth/login'
 */
form.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: form.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Administration\Auth\LoginController::form
 * @see app/Http/Controllers/Administration/Auth/LoginController.php:16
 * @route '/access-administration/auth/login'
 */
form.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: form.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Administration\Auth\LoginController::process
 * @see app/Http/Controllers/Administration/Auth/LoginController.php:26
 * @route '/access-administration/auth/login'
 */
export const process = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: process.url(options),
    method: 'post',
})

process.definition = {
    methods: ["post"],
    url: '/access-administration/auth/login',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Administration\Auth\LoginController::process
 * @see app/Http/Controllers/Administration/Auth/LoginController.php:26
 * @route '/access-administration/auth/login'
 */
process.url = (options?: RouteQueryOptions) => {
    return process.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Administration\Auth\LoginController::process
 * @see app/Http/Controllers/Administration/Auth/LoginController.php:26
 * @route '/access-administration/auth/login'
 */
process.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: process.url(options),
    method: 'post',
})
const login = {
    form: Object.assign(form, form),
process: Object.assign(process, process),
}

export default login