<x-filament::page>
    <div class="max-w-7xl mx-auto space-y-8">
        {{-- صندوق إضافة العميل --}}
        <section class="bg-white shadow-lg rounded-xl p-8 border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    إضافة عميل جديد
                </h2>
                <p class="text-sm text-gray-500">املأ البيانات التالية لإتمام إضافة العميل</p>
            </div>

            <form wire:submit.prevent="createClient" x-data="{ showAdditionalDetails: false }" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- الاسم --}}
                    <div class="space-y-1">
                        <label for="name" class="block text-sm font-medium text-gray-700">الاسم</label>
                        <input id="name" type="text" wire:model.defer="newClientData.name" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition" />
                    </div>

                    {{-- النوع --}}
                    <div class="space-y-1">
                        <label for="type" class="block text-sm font-medium text-gray-700">النوع</label>
                        <select id="type" wire:model.defer="newClientData.type" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                            <option value="">اختر النوع</option>
                            <option value="فردي">فردي</option>
                            <option value="شركة">شركة</option>
                        </select>
                    </div>

                    {{-- البريد الإلكتروني --}}
                    <div class="space-y-1">
                        <label for="email" class="block text-sm font-medium text-gray-700">البريد الإلكتروني</label>
                        <input id="email" type="email" wire:model.defer="newClientData.email" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition" />
                    </div>

                    {{-- رقم الهاتف --}}
                    <div class="space-y-1">
                        <label for="phone" class="block text-sm font-medium text-gray-700">رقم الهاتف</label>
                        <input id="phone" type="text" wire:model.defer="newClientData.phone" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition" />
                    </div>
                </div>

                {{-- زر تفاصيل إضافية --}}
                <div class="pt-2">
                    <button type="button" @click="showAdditionalDetails = !showAdditionalDetails"
                        class="flex items-center gap-2 text-primary-600 hover:text-primary-800 transition">
                        <span>تفاصيل إضافية</span>
                        <svg :class="{ 'rotate-180': showAdditionalDetails }" xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                </div>

                {{-- تفاصيل إضافية --}}
                <div x-show="showAdditionalDetails" x-transition x-cloak class="space-y-6 pt-4 border-t border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- المجال الصناعي --}}
                        <div class="space-y-1">
                            <label for="industry" class="block text-sm font-medium text-gray-700">المجال الصناعي</label>
                            <input id="industry" type="text" wire:model.defer="newClientData.industry"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition" />
                        </div>

                        {{-- حالة العميل --}}
                        <div class="space-y-1">
                            <label for="status" class="block text-sm font-medium text-gray-700">حالة العميل</label>
                            <select id="status" wire:model.defer="newClientData.status" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                                <option value="">اختر الحالة</option>
                                <option value="فعال">فعال</option>
                                <option value="غير فعال">غير فعال</option>
                            </select>
                        </div>
                    </div>

                    {{-- العنوان التفصيلي --}}
                    <div class="space-y-1">
                        <label for="address" class="block text-sm font-medium text-gray-700">العنوان التفصيلي</label>
                        <textarea id="address" rows="3" wire:model.defer="newClientData.address"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"></textarea>
                    </div>

                    {{-- العلامات --}}
                    <div class="space-y-1">
    <label class="block text-sm font-semibold text-gray-800">العلامات</label>
    <div class="flex flex-wrap gap-3 mt-1">
        @foreach ($availableTags as $tag)
            <label class="inline-flex items-center space-x-2 rtl:space-x-reverse cursor-pointer">
                <input type="checkbox" wire:model.defer="newClientData.tags" value="{{ $tag->id }}"
                    class="form-checkbox text-primary-600">
                <span class="text-gray-700">{{ $tag->name }}</span>
            </label>
        @endforeach
    </div>
</div>


                </div>

                {{-- زر الحفظ --}}
                <div class="flex justify-end pt-4">
                    <button type="submit"
                        class="px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg shadow-sm transition flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        حفظ العميل
                    </button>
                </div>
            </form>
        </section>

        {{-- صندوق قائمة العملاء --}}
        <section class="bg-white shadow-lg rounded-xl p-6 border border-gray-100">
    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
        </svg>
        قائمة العملاء
    </h2>

    @if ($clients->isEmpty())
        <div class="text-center py-8">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="mt-2 text-gray-500">لا يوجد عملاء مضافين حتى الآن.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الاسم</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">النوع</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">البريد الإلكتروني</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">رقم الهاتف</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">المجال الصناعي</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الحالة</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">العلامات</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">عدد جهات الاتصال</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($clients as $client)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('filament.admin.resources.clients.edit', $client->id) }}" class="flex items-center gap-2 group">
                                    <span class="font-medium text-gray-900 group-hover:text-primary-600 transition">{{ $client->name }}</span>
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $client->type }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $client->email ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $client->phone ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $client->industry ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded-full {{ $client->status === 'فعال' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $client->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @foreach ($client->tags as $tag)
                                    <span class="inline-block bg-gray-200 rounded px-2 py-1 text-xs mr-1">{{ $tag->name }}</span>
                                @endforeach
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $client->contacts->count() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</section>

    </div>
</x-filament::page>
