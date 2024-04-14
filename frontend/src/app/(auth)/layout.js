import Link from 'next/link'
import AuthCard from '@/app/(auth)/AuthCard'
import ApplicationLogo from '@/components/ApplicationLogo'

export const metadata = {
    title: 'CERTSIMULATOR-AUTH',
}

const Layout = ({ children }) => {
    return (
        <div className="font-sans text-gray-900 antialiased">
            <AuthCard
                logo={
                    <Link href="/">
                        <ApplicationLogo className="w-20 h-20 fill-current text-gray-500" />
                    </Link>
                }>
                {children}
            </AuthCard>
        </div>
    )
}

export default Layout
