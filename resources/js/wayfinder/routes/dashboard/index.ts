import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
/**
* @see \App\Http\Controllers\Administration\Dashboard\DashboardController::index
 * @see app/Http/Controllers/Administration/Dashboard/DashboardController.php:14
 * @route '/access-administration/dashboard'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/access-administration/dashboard',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Administration\Dashboard\DashboardController::index
 * @see app/Http/Controllers/Administration/Dashboard/DashboardController.php:14
 * @route '/access-administration/dashboard'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Administration\Dashboard\DashboardController::index
 * @see app/Http/Controllers/Administration/Dashboard/DashboardController.php:14
 * @route '/access-administration/dashboard'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Administration\Dashboard\DashboardController::index
 * @see app/Http/Controllers/Administration/Dashboard/DashboardController.php:14
 * @route '/access-administration/dashboard'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})
const dashboard = {
    index: Object.assign(index, index),
}

export default dashboard