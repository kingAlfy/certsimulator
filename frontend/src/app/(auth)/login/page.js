'use client'

import {
    Card,
    Input,
    Checkbox,
    Button,
    Typography,
} from '@/lib/MaterialTailwind'

import Link from 'next/link'
import { useAuth } from '@/hooks/auth'
import { useState, useEffect } from 'react'
import { useRouter } from 'next/navigation'
import AuthSessionStatus from '../AuthSessionStatus'

const Login = () => {
    const router = useRouter()

    const { login } = useAuth({
        middleware: 'guest',
        redirectIfAuthenticated: '/dashboard',
    })

    const [email, setEmail] = useState('')
    const [password, setPassword] = useState('')
    const [shouldRemember, setShouldRemember] = useState(false)
    const [status, setStatus] = useState(null)
    const [errors, setErrors] = useState([])
    
    useEffect(() => {
        if (router.reset?.length > 0 && errors.length === 0) {
            setStatus(atob(router.reset))
        } else {
            setStatus(null)
        }
    })

    const submitForm = async event => {
        event.preventDefault()
        const sample = {
            email,
            password,
            remember: shouldRemember,
            setErrors,
        }
        console.log('sample:', sample)

        login({
            email,
            password,
            remember: shouldRemember,
            setErrors,
        })
        console.log(errors);
    }

    return (
        <>
            <Card
                color="transparent"
                shadow={false}
                className="m-1 max-w-screen-lg">
                <Typography
                    variant="h4"
                    color="blue-gray"
                    className="mr-1 ml-1">
                    Log in
                </Typography>
                { /* TODO: try with errors.message */ }
                {errors.email != null ? (
                    <Typography
                        className="-mb-4 mr-1 ml-1 text-normal text-red-600">
                    {errors.email}
                    </Typography>
                ) : null}
                <AuthSessionStatus />
                <form
                    className="mt-8 mb-2 w-80 max-w-screen-lg sm:w-96 m-1"
                    onSubmit={submitForm}>
                    <div className="mb-1 flex flex-col gap-6">
                        <Typography
                            variant="h6"
                            color="blue-gray"
                            className="-mb-5">
                            Your Email
                        </Typography>
                        <Input
                            id="email"
                            type="email"
                            value={email}
                            onChange={event => setEmail(event.target.value)}
                            size="lg"
                            placeholder="name@mail.com"
                            className="!border-t-blue-gray-200 focus:!border-t-gray-900"
                            labelProps={{
                                className:
                                    'before:content-none after:content-none',
                            }}
                            autoFocus
                        />
                        <Typography
                            variant="h6"
                            color="blue-gray"
                            className="-mb-5">
                            Password
                        </Typography>
                        <Input
                            id="password"
                            type="password"
                            value={password}
                            onChange={event => setPassword(event.target.value)}
                            size="lg"
                            placeholder="********"
                            className="!border-t-blue-gray-200 focus:!border-t-gray-900"
                            labelProps={{
                                className:
                                    'before:content-none after:content-none',
                            }}
                            autoComplete="current-password"
                        />
                        <div className="-m-3">
                            <Checkbox
                                label="Remember Me"
                                onChange={event =>
                                    setShouldRemember(event.target.checked)
                                }
                                id="remember_me"
                                type="checkbox"
                                name="remember"
                            />
                        </div>
                    </div>

                    <Button type="submit" className="mt-6" fullWidth>
                        log in
                    </Button>

                    <Typography
                        color="gray"
                        className="mt-4 text-center font-normal">
                        <Link
                            href="/forgot-password"
                            className="underline text-sm text-gray-600 hover:text-gray-900">
                            Forgot your password?
                        </Link>
                    </Typography>
                </form>
            </Card>
        </>
    )
}

export default Login
