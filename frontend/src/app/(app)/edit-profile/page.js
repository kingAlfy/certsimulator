import CardProfile from '@/components/CardProfile'

export const metadata = {
    title: 'CERTSIMULATOR - Edit Profile',
}

const cards = [
    {
        title: "DELETE ACCOUNT",
        text: "If you want to delete your account click in:",
        btnText: "DELETE ACCOUNT",
        btnStyle: "mt-6 bg-red-700",
        logicType: "delete"
    },
    {
        title: "EMAIL VERIFICATION",
        text: " If you want to receive a new verification email click in:",
        btnText: "SEND EMAIL",
        btnStyle: "mt-6 bg-red-700",
        logicType: "verification"
    }
]

const EditProfile = () => {
    return (
        <div className='h-full w-full flex flex-col items-center content-center justify-end'>
            {cards.map((card, index) => <CardProfile key={index} card={card}/>)}
        </div>
    )
}

export default EditProfile
