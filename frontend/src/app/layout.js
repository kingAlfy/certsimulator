import '@/app/global.css'
import { ThemeProvider } from '@/lib/MaterialTailwind'


export const metadata = {
    title: 'CERTSIMULATOR',
}
const RootLayout = ({ children }) => {
    return (
        <ThemeProvider>
            <html lang="es">
                <body className="antialiased w-screen h-screen">{children}</body>
            </html>
        </ThemeProvider>
    )
}

export default RootLayout