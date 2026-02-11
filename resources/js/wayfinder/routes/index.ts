import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../wayfinder'
/**
* @see \App\Http\Controllers\Administration\Auth\LoginController::logout
 * @see app/Http/Controllers/Administration/Auth/LoginController.php:47
 * @route '/access-administration/logout'
 */
export const logout = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: logout.url(options),
    method: 'post',
})

logout.definition = {
    methods: ["post"],
    url: '/access-administration/logout',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Administration\Auth\LoginController::logout
 * @see app/Http/Controllers/Administration/Auth/LoginController.php:47
 * @route '/access-administration/logout'
 */
logout.url = (options?: RouteQueryOptions) => {
    return logout.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Administration\Auth\LoginController::logout
 * @see app/Http/Controllers/Administration/Auth/LoginController.php:47
 * @route '/access-administration/logout'
 */
logout.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: logout.url(options),
    method: 'post',
})