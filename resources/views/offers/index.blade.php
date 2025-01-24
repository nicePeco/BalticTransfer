<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
    <div>
            <section class="text-gray-600 body-font relative">
        <div class="absolute inset-0 bg-gray-300">
            <iframe width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0" title="map" scrolling="no" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d139178.64036654524!2d23.964268461123655!3d56.971649187250094!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46eecfb0e5073ded%3A0x400cfcd68f2fe30!2zUsSrZ2E!5e0!3m2!1slv!2slv!4v1724671358337!5m2!1slv!2slv"></iframe>
        </div>
            <div class="container px-5 py-24 mx-auto flex">
                <div class="lg:w-1/3 md:w-1/2 bg-white rounded-lg p-8 flex flex-col md:ml-auto w-full mt-10 md:mt-0 relative z-10 shadow-md">
                    <h2 class="text-gray-900 text-lg mb-1 font-medium title-font">Destionation</h2>
                    <p class="leading-relaxed mb-5 text-gray-600">Fill these fields to set up a request for a pick up.</p>
                    <div class="w-full md:w-96 md:max-w-full mx-auto py-2">
                        <div class="p-6 border border-gray-300 sm:rounded-md">
                            <form
                            method="post"
                            action="{{ route('offers.store') }}"
                            enctype="multipart/form-data"
                            >
                            @csrf
                            <input type="hidden" name="offers_id" value="{{ auth()->user()->id }}">
                            <h4 class="text-lg text-green-500">From country</h4>
                            <label for="location_one" class="block mb-6">
                                <input
                                name="location_one"
                                id="location_one"
                                type="text"
                                class="
                                    block
                                    w-full
                                    mt-1
                                    border-gray-300
                                    rounded-md
                                    shadow-sm
                                    focus:border-indigo-300
                                    focus:ring
                                    focus:ring-indigo-200
                                    focus:ring-opacity-50
                                "
                                placeholder=""
                                />
                            </label>
                            <label for="city_one" class="block mb-6">
                                <span class="text-gray-700">City, pick up point: street, house number</span>
                                <input
                                name="city_one"
                                id="city_one"
                                type="text"
                                class="
                                    block
                                    w-full
                                    mt-1
                                    border-gray-300
                                    rounded-md
                                    shadow-sm
                                    focus:border-indigo-300
                                    focus:ring
                                    focus:ring-indigo-200
                                    focus:ring-opacity-50
                                "
                                placeholder=""
                                />
                            </label>
                            <h4 class="text-lg text-blue-500">To country</h4>
                            <label for="location_two" class="block mb-6">
                                <input
                                name="location_two"
                                id="location_two"
                                type="text"
                                class="
                                    block
                                    w-full
                                    mt-1
                                    border-gray-300
                                    rounded-md
                                    shadow-sm
                                    focus:border-indigo-300
                                    focus:ring
                                    focus:ring-indigo-200
                                    focus:ring-opacity-50
                                "
                                placeholder=""
                                />
                            </label>   
                            <label for="city_two" class="block mb-6">
                                <span class="text-gray-700">City, drop off point: street, house number.</span>
                                <input
                                name="city_two"
                                id="city_two"
                                type="text"
                                class="
                                    block
                                    w-full
                                    mt-1
                                    border-gray-300
                                    rounded-md
                                    shadow-sm
                                    focus:border-indigo-300
                                    focus:ring
                                    focus:ring-indigo-200
                                    focus:ring-opacity-50
                                "
                                placeholder=""
                                />
                            </label>                   
                            <label for="information" class="block mb-6">
                                <span class="text-gray-700">Date, time/Information</span>
                                <textarea
                                    name="information"
                                    id="information"
                                    type="text"
                                    class="
                                        block
                                        w-full
                                        mt-1
                                        border-gray-300
                                        rounded-md
                                        shadow-sm
                                        focus:border-indigo-300
                                        focus:ring
                                        focus:ring-indigo-200
                                        focus:ring-opacity-50
                                    "
                                    rows="3"
                                    placeholder="Information for driver."
                                    required
                                ></textarea>
                            </label>
                        </div>
                        </div>
                    <button class="text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg">Sumbit</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>