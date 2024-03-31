import {
    Card,
    CardHeader,
    CardBody,
    CardFooter,
    Typography,
    Button,
} from '@/lib/MaterialTailwind'

export const metadata = {
    title: 'CERTSIMULATOR - Edit Profile',
}

const EditProfile = () => {
    return (
        <div className='my-5 h-full w-full flex flex-col items-center content-center justify-end '>
            <Card className="max-w-screen-sm sm:my-0 sm:mx-auto ">
                <CardHeader
                    floated={false}
                    className="m-3 grid h-28 place-items-center bg-gray-900">
                    <Typography variant="h3" color="white">
                        DELETE ACCOUNT
                    </Typography>
                </CardHeader>
                <CardBody className="text-center">
                    <Typography color="blue-gray">
                        If you want to delete your account click in:
                    </Typography>
                    <Button type="submit" className="mt-6 bg-red-700" fullWidth>
                        DELETE ACCOUNT
                    </Button>
                </CardBody>
            </Card>
        </div>
    )
}

export default EditProfile
