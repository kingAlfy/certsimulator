'use client'
import { useAuth } from '@/hooks/auth'
import {
    Card,
    CardHeader,
    CardBody,
    Typography,
    Button,
} from '@/lib/MaterialTailwind'

const ProfileCard = props => {
    const { title, text, btnText, btnStyle, logicType } = props.card

    const { resendEmailVerification } = useAuth({
        middleware: 'auth'
    })

    const handleClickEmailVerification = e => {
        // TODO: Add toast to offer feedback

        resendEmailVerification({})
    }

    const handleClickDeleteAccount = (e) => {
        // TODO: Logic to delete user account
        console.log('delete')
    }

    return (
        <Card className="mt-3 max-w-80 w-full sm:max-w-lg sm:mx-auto ">
            <CardHeader
                floated={false}
                className="m-3 grid h-28 place-items-center bg-gray-900">
                <Typography variant="h3" color="white" className="text-center">
                    {title}
                </Typography>
            </CardHeader>
            <CardBody className="text-center">
                <Typography color="blue-gray">{text}</Typography>
                <Button
                    type="submit"
                    onClick={
                        logicType == 'verification'
                            ? (e) => handleClickEmailVerification(e)
                            : (e) => handleClickDeleteAccount(e)
                    }
                    className={btnStyle}
                    fullWidth>
                    {btnText}
                </Button>
            </CardBody>
        </Card>
    )
}

export default ProfileCard
