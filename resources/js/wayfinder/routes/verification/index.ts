import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../wayfinder'
/**
* @see \App\Http\Controllers\Administration\Auth\EmailVerificationController::notice
 * @see app/Http/Controllers/Administration/Auth/EmailVerificationController.php:15
 * @route '/access-administration/email/verify'
 */
export const notice = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: notice.url(options),
    method: 'get',
})

notice.definition = {
    methods: ["get","head"],
    url: '/access-administration/email/verify',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Administration\Auth\EmailVerificationController::notice
 * @see app/Http/Controllers/Administration/Auth/EmailVerificationController.php:15
 * @route '/access-administration/email/verify'
 */
notice.url = (options?: RouteQueryOptions) => {
    return notice.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Administration\Auth\EmailVerificationController::notice
 * @see app/Http/Controllers/Administration/Auth/EmailVerificationController.php:15
 * @route '/access-administration/email/verify'
 */
notice.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: notice.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Administration\Auth\EmailVerificationController::notice
 * @see app/Http/Controllers/Administration/Auth/EmailVerificationController.php:15
 * @route '/access-administration/email/verify'
 */
notice.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: notice.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Administration\Auth\EmailVerificationController::verify
 * @see app/Http/Controllers/Administration/Auth/EmailVerificationController.php:24
 * @route '/access-administration/email/verify/{id}/{hash}'
 */
export const verify = (args: { id: string | number, hash: string | number } | [id: string | number, hash: string | number ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: verify.url(args, options),
    method: 'get',
})

verify.definition = {
    methods: ["get","head"],
    url: '/access-administration/email/verify/{id}/{hash}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Administration\Auth\EmailVerificationController::verify
 * @see app/Http/Controllers/Administration/Auth/EmailVerificationController.php:24
 * @route '/access-administration/email/verify/{id}/{hash}'
 */
verify.url = (args: { id: string | number, hash: string | number } | [id: string | number, hash: string | number ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
                    id: args[0],
                    hash: args[1],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        id: args.id,
                                hash: args.hash,
                }

    return verify.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace('{hash}', parsedArgs.hash.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Administration\Auth\EmailVerificationController::verify
 * @see app/Http/Controllers/Administration/Auth/EmailVerificationController.php:24
 * @route '/access-administration/email/verify/{id}/{hash}'
 */
verify.get = (args: { id: string | number, hash: string | number } | [id: string | number, hash: string | number ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: verify.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Administration\Auth\EmailVerificationController::verify
 * @see app/Http/Controllers/Administration/Auth/EmailVerificationController.php:24
 * @route '/access-administration/email/verify/{id}/{hash}'
 */
verify.head = (args: { id: string | number, hash: string | number } | [id: string | number, hash: string | number ], options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: verify.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Administration\Auth\EmailVerificationController::send
 * @see app/Http/Controllers/Administration/Auth/EmailVerificationController.php:33
 * @route '/access-administration/email/verification-notification'
 */
export const send = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: send.url(options),
    method: 'get',
})

send.definition = {
    methods: ["get","head"],
    url: '/access-administration/email/verification-notification',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Administration\Auth\EmailVerificationController::send
 * @see app/Http/Controllers/Administration/Auth/EmailVerificationController.php:33
 * @route '/access-administration/email/verification-notification'
 */
send.url = (options?: RouteQueryOptions) => {
    return send.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Administration\Auth\EmailVerificationController::send
 * @see app/Http/Controllers/Administration/Auth/EmailVerificationController.php:33
 * @route '/access-administration/email/verification-notification'
 */
send.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: send.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Administration\Auth\EmailVerificationController::send
 * @see app/Http/Controllers/Administration/Auth/EmailVerificationController.php:33
 * @route '/access-administration/email/verification-notification'
 */
send.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: send.url(options),
    method: 'head',
})
const verification = {
    notice: Object.assign(notice, notice),
verify: Object.assign(verify, verify),
send: Object.assign(send, send),
}

export default verification