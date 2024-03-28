'use client'

/* import Button from '@/components/Button'
import Input from '@/components/Input'
import InputError from '@/components/InputError'
import Label from '@/components/Label' */
import Link from 'next/link'
import { useAuth } from '@/hooks/auth'
import { useState } from 'react'
import {
    Card,
    Input,
    Checkbox,
    Button,
    Typography,
} from '@/lib/MaterialTailwind'

const Page = () => {
    const { register } = useAuth({
        middleware: 'guest',
        redirectIfAuthenticated: '/dashboard',
    })

    const [name, setName] = useState('')
    const [email, setEmail] = useState('')
    const [password, setPassword] = useState('')
    const [passwordConfirmation, setPasswordConfirmation] = useState('')
    const [errors, setErrors] = useState([])

    const submitForm = event => {
        event.preventDefault()
        console.log('sample', {
            name,
            email,
            password,
            password_confirmation: passwordConfirmation,
            setErrors,
        })

        register({
            name,
            email,
            password,
            password_confirmation: passwordConfirmation,
            setErrors,
        })
    }

    return (
        <div>
            <Card color="transparent" shadow={false}>
                <Typography variant="h4" color="blue-gray">
                    Sign Up
                </Typography>
                <Typography color="gray" className="mt-1 font-normal">
                    You should ask to know the code.
                </Typography>
                <form
                    className="mt-8 mb-2 w-80 max-w-screen-lg sm:w-96"
                    onSubmit={submitForm}>
                    <div className="mb-1 flex flex-col gap-6">
                        <Typography
                            variant="h6"
                            color="blue-gray"
                            className="-mb-5">
                            Your Name
                        </Typography>
                        <Input
                            size="lg"
                            placeholder="name"
                            className=" !border-t-blue-gray-200 focus:!border-t-gray-900"
                            labelProps={{
                                className:
                                    'before:content-none after:content-none',
                            }}
                            id="name"
                            type="text"
                            value={name}
                            onChange={event => setName(event.target.value)}
                            autoFocus
                        />
                        <Typography
                            variant="h6"
                            color="blue-gray"
                            className="-mb-5">
                            Your Email
                        </Typography>
                        <Input
                            size="lg"
                            placeholder="name@mail.com"
                            className=" !border-t-blue-gray-200 focus:!border-t-gray-900"
                            labelProps={{
                                className:
                                    'before:content-none after:content-none',
                            }}
                            id="email"
                            type="email"
                            value={email}
                            onChange={event => setEmail(event.target.value)}
                        />
                        <Typography
                            variant="h6"
                            color="blue-gray"
                            className="-mb-5">
                            Password
                        </Typography>
                        <Input
                            type="password"
                            size="lg"
                            placeholder="********"
                            className=" !border-t-blue-gray-200 focus:!border-t-gray-900"
                            labelProps={{
                                className:
                                    'before:content-none after:content-none',
                            }}
                            id="password"
                            value={password}
                            onChange={event => setPassword(event.target.value)}
                            autoComplete="new-password"
                        />
                        <Typography
                            variant="h6"
                            color="blue-gray"
                            className="-mb-5">
                            Confirm password
                        </Typography>
                        <Input
                            type="password"
                            size="lg"
                            placeholder="********"
                            className=" !border-t-blue-gray-200 focus:!border-t-gray-900"
                            labelProps={{
                                className:
                                    'before:content-none after:content-none',
                            }}
                            id="passwordConfirmation"
                            value={passwordConfirmation}
                            onChange={event =>
                                setPasswordConfirmation(event.target.value)
                            }
                        />
                        <Typography
                            variant="h6"
                            color="blue-gray"
                            className="-mb-5">
                            Code
                        </Typography>
                        <Input
                            type="text"
                            size="lg"
                            placeholder="1234-1234"
                            className=" !border-t-blue-gray-200 focus:!border-t-gray-900"
                            labelProps={{
                                className:
                                    'before:content-none after:content-none',
                            }}
                            id="passwordConfirmation"
                            value={passwordConfirmation}
                            onChange={event =>
                                setPasswordConfirmation(event.target.value)
                            }
                        />
                    </div>
                    <Checkbox
                        label={
                            <Typography
                                variant="small"
                                color="gray"
                                className="flex items-center font-normal">
                                I agree the
                                <a
                                    href="#"
                                    className="font-medium transition-colors hover:text-gray-900">
                                    &nbsp;Terms and Conditions
                                </a>
                            </Typography>
                        }
                        containerProps={{ className: '-ml-2.5' }}
                    />
                    <Button type="submit" className="mt-6" fullWidth>
                        sign up
                    </Button>
                    <Typography
                        color="gray"
                        className="mt-4 text-center font-normal">
                        Already have an account?{' '}
                        <a href="/login" className="font-medium text-gray-900">
                            Sign In
                        </a>
                    </Typography>
                </form>
            </Card>
        </div>
    )
}

export default Page
