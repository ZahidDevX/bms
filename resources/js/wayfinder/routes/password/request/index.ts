import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Administration\Auth\PasswordResetController::form
 * @see app/Http/Controllers/Administration/Auth/PasswordResetController.php:19
 * @route '/access-administration/password/request'
 */
export const form = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: form.url(options),
    method: 'get',
})

form.definition = {
    methods: ["get","head"],
    url: '/access-administration/password/request',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Administration\Auth\PasswordResetController::form
 * @see app/Http/Controllers/Administration/Auth/PasswordResetController.php:19
 * @route '/access-administration/password/request'
 */
form.url = (options?: RouteQueryOptions) => {
    return form.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Administration\Auth\PasswordResetController::form
 * @see app/Http/Controllers/Administration/Auth/PasswordResetController.php:19
 * @route '/access-administration/password/request'
 */
form.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: form.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Administration\Auth\PasswordResetController::form
 * @see app/Http/Controllers/Administration/Auth/PasswordResetController.php:19
 * @route '/access-administration/password/request'
 */
form.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: form.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Administration\Auth\PasswordResetController::send
 * @see app/Http/Controllers/Administration/Auth/PasswordResetController.php:27
 * @route '/access-administration/password/request'
 */
export const send = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: send.url(options),
    method: 'post',
})

send.definition = {
    methods: ["post"],
    url: '/access-administration/password/request',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Administration\Auth\PasswordResetController::send
 * @see app/Http/Controllers/Administration/Auth/PasswordResetController.php:27
 * @route '/access-administration/password/request'
 */
send.url = (options?: RouteQueryOptions) => {
    return send.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Administration\Auth\PasswordResetController::send
 * @see app/Http/Controllers/Administration/Auth/PasswordResetController.php:27
 * @route '/access-administration/password/request'
 */
send.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: send.url(options),
    method: 'post',
})
const request = {
    form: Object.assign(form, form),
send: Object.assign(send, send),
}

export default request