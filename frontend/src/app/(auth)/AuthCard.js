// w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg flex flex-col align-items-center justify-content-center  -> Classname anterior

const AuthCard = ({ logo, children }) => (
    <div className="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div>{logo}</div>

        <div className="rounded-lg px-3 shadow-md sm:px-2 md:px-6 py-4 bg-white mt-6 ">
            {children}
        </div>
    </div>
)

export default AuthCard
