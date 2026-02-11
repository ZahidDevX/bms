import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Administration\Auth\PasswordResetController::process
 * @see app/Http/Controllers/Administration/Auth/PasswordResetController.php:54
 * @route '/access-administration/password/reset'
 */
export const process = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: process.url(options),
    method: 'post',
})

process.definition = {
    methods: ["post"],
    url: '/access-administration/password/reset',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Administration\Auth\PasswordResetController::process
 * @see app/Http/Controllers/Administration/Auth/PasswordResetController.php:54
 * @route '/access-administration/password/reset'
 */
process.url = (options?: RouteQueryOptions) => {
    return process.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Administration\Auth\PasswordResetController::process
 * @see app/Http/Controllers/Administration/Auth/PasswordResetController.php:54
 * @route '/access-administration/password/reset'
 */
process.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: process.url(options),
    method: 'post',
})
const reset = {
    process: Object.assign(process, process),
}

export default reset