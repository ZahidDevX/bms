import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../wayfinder'
import request from './request'
import reset0fffd7 from './reset'
/**
* @see \App\Http\Controllers\Administration\Auth\PasswordResetController::reset
 * @see app/Http/Controllers/Administration/Auth/PasswordResetController.php:43
 * @route '/access-administration/password/reset/{token}'
 */
export const reset = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: reset.url(args, options),
    method: 'get',
})

reset.definition = {
    methods: ["get","head"],
    url: '/access-administration/password/reset/{token}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Administration\Auth\PasswordResetController::reset
 * @see app/Http/Controllers/Administration/Auth/PasswordResetController.php:43
 * @route '/access-administration/password/reset/{token}'
 */
reset.url = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { token: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    token: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        token: args.token,
                }

    return reset.definition.url
            .replace('{token}', parsedArgs.token.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Administration\Auth\PasswordResetController::reset
 * @see app/Http/Controllers/Administration/Auth/PasswordResetController.php:43
 * @route '/access-administration/password/reset/{token}'
 */
reset.get = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: reset.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Administration\Auth\PasswordResetController::reset
 * @see app/Http/Controllers/Administration/Auth/PasswordResetController.php:43
 * @route '/access-administration/password/reset/{token}'
 */
reset.head = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: reset.url(args, options),
    method: 'head',
})
const password = {
    request: Object.assign(request, request),
reset: Object.assign(reset, reset0fffd7),
}

export default password