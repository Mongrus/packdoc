<script setup>
import { ref } from 'vue';

const props = defineProps({
    form: { type: Object, required: true },
});

const emit = defineEmits(['focus-field']);

const v = (val, fallback = '—') => val || fallback;

const activeTab = ref('contract');

const tabs = [
    { id: 'contract', label: 'Договор' },
    { id: 'act', label: 'Акт' },
    { id: 'invoice', label: 'Инвойс' },
];

function onDocClick(e) {
    const el = e.target.closest('[data-field]');
    if (el) emit('focus-field', el.dataset.field);
}
</script>

<template>
    <div>
        <!-- Tabs -->
        <div class="mb-3 flex rounded-lg bg-gray-100 p-1">
            <button
                v-for="tab in tabs"
                :key="tab.id"
                @click="activeTab = tab.id"
                :class="[
                    'flex-1 rounded-md px-3 py-1.5 text-xs font-medium transition',
                    activeTab === tab.id
                        ? 'bg-white text-gray-900 shadow-sm'
                        : 'text-gray-500 hover:text-gray-700',
                ]"
            >
                {{ tab.label }}
            </button>
        </div>

        <!-- A4 page -->
        <div class="overflow-hidden rounded-xl bg-white shadow-lg ring-1 ring-gray-200">
            <div class="max-h-[78vh] overflow-y-auto">
                <div class="doc-page px-8 py-8 text-[11px] leading-[1.7] text-gray-700" @click="onDocClick">

                    <!-- ═══ CONTRACT ═══ -->
                    <template v-if="activeTab === 'contract'">
                        <p class="text-center text-[16px] font-bold tracking-wide text-gray-900">
                            ДОГОВОР № <span class="fld" data-field="contract_number">{{ v(form.contract_number) }}</span>
                        </p>
                        <p class="mb-3 text-center text-[12px] text-gray-500">на оказание услуг</p>

                        <div class="mb-4 flex justify-between text-gray-500">
                            <span>г. <span class="fld" data-field="contract_city">{{ v(form.contract_city) }}</span></span>
                            <span>Дата: <span class="fld" data-field="contract_date">{{ v(form.contract_date) }}</span></span>
                        </div>

                        <hr class="my-3 border-gray-200">

                        <p class="mb-1.5 text-[10px] font-bold uppercase tracking-widest text-gray-400">1. Стороны договора</p>
                        <p><strong>Исполнитель:</strong> <span class="fld" data-field="contractor_name">{{ v(form.contractor_name) }}</span>, email: <span class="fld" data-field="contractor_email">{{ v(form.contractor_email) }}</span><template v-if="form.contractor_phone">, тел.: <span class="fld" data-field="contractor_phone">{{ form.contractor_phone }}</span></template></p>
                        <p><strong>Заказчик:</strong> <span class="fld" data-field="client_name">{{ v(form.client_name) }}</span>, email: <span class="fld" data-field="client_email">{{ v(form.client_email) }}</span></p>

                        <hr class="my-3 border-gray-200">

                        <p class="mb-1.5 text-[10px] font-bold uppercase tracking-widest text-gray-400">2. Предмет договора</p>
                        <p>2.1. Исполнитель обязуется оказать следующие услуги:</p>
                        <p class="ml-2 fld" data-field="service_description">{{ v(form.service_description) }}</p>
                        <p>2.2. Заказчик обязуется принять и оплатить оказанные услуги.</p>

                        <hr class="my-3 border-gray-200">

                        <p class="mb-1.5 text-[10px] font-bold uppercase tracking-widest text-gray-400">3. Сроки оказания услуг</p>
                        <p>3.1. Срок выполнения работ: с <span class="font-semibold fld" data-field="start_date">{{ v(form.start_date) }}</span> по <span class="font-semibold fld" data-field="end_date">{{ v(form.end_date) }}</span></p>

                        <hr class="my-3 border-gray-200">

                        <p class="mb-1.5 text-[10px] font-bold uppercase tracking-widest text-gray-400">4. Стоимость и порядок оплаты</p>
                        <p>4.1. Общая стоимость услуг составляет: <span class="font-semibold fld" data-field="price">{{ v(form.price) }} {{ form.currency }}</span></p>
                        <p>4.2. Оплата производится на основании выставленного инвойса.</p>
                        <p>4.3. Срок оплаты: <span class="fld" data-field="payment_terms">{{ v(form.payment_terms) }}</span></p>

                        <hr class="my-3 border-gray-200">

                        <p class="mb-1.5 text-[10px] font-bold uppercase tracking-widest text-gray-400">5. Порядок сдачи и приёмки</p>
                        <p>5.1. По завершении работ Исполнитель направляет результат Заказчику.</p>
                        <p>5.2. Заказчик обязан в течение <span class="font-semibold fld" data-field="acceptance_days">{{ v(form.acceptance_days) }}</span> дней:</p>
                        <ul class="ml-3 list-disc">
                            <li>либо принять работы;</li>
                            <li>либо направить мотивированные замечания.</li>
                        </ul>
                        <p>5.3. При отсутствии ответа работы считаются принятыми.</p>

                        <hr class="my-3 border-gray-200">

                        <p class="mb-1.5 text-[10px] font-bold uppercase tracking-widest text-gray-400">6. Права и обязанности сторон</p>
                        <p><strong>Исполнитель обязуется:</strong></p>
                        <ul class="ml-3 list-disc">
                            <li>выполнить услуги качественно и в срок;</li>
                            <li>информировать Заказчика о ходе работ.</li>
                        </ul>
                        <p><strong>Заказчик обязуется:</strong></p>
                        <ul class="ml-3 list-disc">
                            <li>предоставить необходимые данные;</li>
                            <li>своевременно оплатить услуги.</li>
                        </ul>

                        <hr class="my-3 border-gray-200">

                        <p class="mb-1.5 text-[10px] font-bold uppercase tracking-widest text-gray-400">7. Ответственность сторон</p>
                        <p>7.1. Штраф за нарушение сроков: <span class="fld" data-field="penalty_terms">{{ v(form.penalty_terms) }}</span></p>
                        <p>7.2. Исполнитель не несёт ответственности за убытки, превышающие сумму договора.</p>

                        <hr class="my-3 border-gray-200">

                        <p class="mb-1.5 text-[10px] font-bold uppercase tracking-widest text-gray-400">8. Конфиденциальность</p>
                        <p>Стороны обязуются не разглашать информацию, полученную в рамках настоящего договора.</p>

                        <hr class="my-3 border-gray-200">

                        <p class="mb-1.5 text-[10px] font-bold uppercase tracking-widest text-gray-400">9. Форс-мажор</p>
                        <p>Стороны освобождаются от ответственности при наступлении обстоятельств непреодолимой силы.</p>

                        <hr class="my-3 border-gray-200">

                        <p class="mb-1.5 text-[10px] font-bold uppercase tracking-widest text-gray-400">10. Заключительные положения</p>
                        <p>10.1. Договор вступает в силу с момента подписания обеими сторонами.</p>
                        <p>10.2. Все споры решаются путём переговоров.</p>

                        <hr class="my-3 border-gray-200">

                        <div class="mt-6 flex justify-between">
                            <div>
                                <p class="text-[10px] font-bold text-gray-400">Исполнитель:</p>
                                <div class="mt-3 w-28 border-b border-gray-400"></div>
                                <p class="mt-0.5 text-[10px] text-gray-500">{{ v(form.contractor_name, '') }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400">Заказчик:</p>
                                <div class="mt-3 w-28 border-b border-gray-400"></div>
                                <p class="mt-0.5 text-[10px] text-gray-500">{{ v(form.client_name, '') }}</p>
                            </div>
                        </div>
                    </template>

                    <!-- ═══ ACT ═══ -->
                    <template v-if="activeTab === 'act'">
                        <p class="text-center text-[16px] font-bold tracking-wide text-gray-900">
                            АКТ № <span class="fld" data-field="act_number">{{ v(form.act_number) }}</span>
                        </p>
                        <p class="mb-3 text-center text-[12px] text-gray-500">выполненных работ</p>

                        <div class="mb-4 flex justify-between text-gray-500">
                            <span>г. <span class="fld" data-field="contract_city">{{ v(form.contract_city) }}</span></span>
                            <span>Дата: <span class="fld" data-field="contract_date">{{ v(form.contract_date) }}</span></span>
                        </div>

                        <hr class="my-3 border-gray-200">

                        <p class="mb-1.5 text-[10px] font-bold uppercase tracking-widest text-gray-400">1. Стороны</p>
                        <p><strong>Исполнитель:</strong> <span class="fld" data-field="contractor_name">{{ v(form.contractor_name) }}</span></p>
                        <p><strong>Заказчик:</strong> <span class="fld" data-field="client_name">{{ v(form.client_name) }}</span></p>

                        <hr class="my-3 border-gray-200">

                        <p class="mb-1.5 text-[10px] font-bold uppercase tracking-widest text-gray-400">2. Основание</p>
                        <p>Договор № <span class="fld" data-field="contract_number">{{ v(form.contract_number) }}</span> от <span class="fld" data-field="contract_date">{{ v(form.contract_date) }}</span></p>

                        <hr class="my-3 border-gray-200">

                        <p class="mb-1.5 text-[10px] font-bold uppercase tracking-widest text-gray-400">3. Выполненные работы</p>
                        <p class="fld" data-field="service_description">{{ v(form.service_description) }}</p>

                        <hr class="my-3 border-gray-200">

                        <p class="mb-1.5 text-[10px] font-bold uppercase tracking-widest text-gray-400">4. Стоимость</p>
                        <p>Общая стоимость выполненных работ: <span class="font-semibold fld" data-field="price">{{ v(form.price) }} {{ form.currency }}</span></p>

                        <hr class="my-3 border-gray-200">

                        <p class="mb-1.5 text-[10px] font-bold uppercase tracking-widest text-gray-400">5. Подтверждение</p>
                        <p>Стороны подтверждают, что:</p>
                        <ul class="ml-3 list-disc">
                            <li>работы выполнены в полном объёме;</li>
                            <li>претензий по качеству и срокам нет.</li>
                        </ul>

                        <hr class="my-3 border-gray-200">

                        <p class="mb-1.5 text-[10px] font-bold uppercase tracking-widest text-gray-400">6. Юридическое значение</p>
                        <p>Настоящий акт является основанием для окончательного расчёта между сторонами.</p>

                        <hr class="my-3 border-gray-200">

                        <div class="mt-6 flex justify-between">
                            <div>
                                <p class="text-[10px] font-bold text-gray-400">Исполнитель:</p>
                                <div class="mt-3 w-28 border-b border-gray-400"></div>
                                <p class="mt-0.5 text-[10px] text-gray-500">{{ v(form.contractor_name, '') }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400">Заказчик:</p>
                                <div class="mt-3 w-28 border-b border-gray-400"></div>
                                <p class="mt-0.5 text-[10px] text-gray-500">{{ v(form.client_name, '') }}</p>
                            </div>
                        </div>
                    </template>

                    <!-- ═══ INVOICE ═══ -->
                    <template v-if="activeTab === 'invoice'">
                        <p class="text-[20px] font-bold tracking-wider text-gray-900">INVOICE</p>
                        <p class="text-[12px] text-gray-500">№ <span class="fld" data-field="invoice_number">{{ v(form.invoice_number) }}</span></p>
                        <p class="mb-4 text-[10px] text-gray-400">Date: <span class="fld" data-field="contract_date">{{ v(form.contract_date) }}</span></p>

                        <hr class="my-3 border-gray-200">

                        <div class="flex gap-6">
                            <div class="flex-1">
                                <p class="mb-1 text-[9px] font-bold uppercase tracking-widest text-gray-400">From</p>
                                <p class="font-semibold fld" data-field="contractor_name">{{ v(form.contractor_name) }}</p>
                                <p class="fld" data-field="contractor_email">{{ v(form.contractor_email) }}</p>
                                <p v-if="form.contractor_phone" class="fld" data-field="contractor_phone">{{ form.contractor_phone }}</p>
                            </div>
                            <div class="flex-1">
                                <p class="mb-1 text-[9px] font-bold uppercase tracking-widest text-gray-400">To</p>
                                <p class="font-semibold fld" data-field="client_name">{{ v(form.client_name) }}</p>
                                <p class="fld" data-field="client_email">{{ v(form.client_email) }}</p>
                            </div>
                        </div>

                        <hr class="my-3 border-gray-200">

                        <p class="mb-1.5 text-[9px] font-bold uppercase tracking-widest text-gray-400">Description</p>

                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="border-b-2 border-gray-200 bg-gray-50 text-[9px] font-bold uppercase tracking-wider text-gray-400">
                                    <th class="px-2 py-1.5 text-left">Service</th>
                                    <th class="px-2 py-1.5 text-left">Description</th>
                                    <th class="px-2 py-1.5 text-right">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-gray-100">
                                    <td class="px-2 py-1.5 fld" data-field="service_name">{{ v(form.service_name) }}</td>
                                    <td class="px-2 py-1.5 fld" data-field="service_description">{{ v(form.service_description) }}</td>
                                    <td class="px-2 py-1.5 text-right font-semibold fld" data-field="price">{{ v(form.price) }} {{ form.currency }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <p class="mt-2 text-right text-[11px] font-bold text-gray-900">
                            Total: <span class="fld" data-field="price">{{ v(form.price) }} {{ form.currency }}</span>
                        </p>

                        <hr class="my-3 border-gray-200">

                        <div class="flex gap-6">
                            <div class="flex-1">
                                <p class="mb-1 text-[9px] font-bold uppercase tracking-widest text-gray-400">Payment Terms</p>
                                <p class="fld" data-field="payment_terms">{{ v(form.payment_terms) }}</p>
                            </div>
                            <div class="flex-1">
                                <p class="mb-1 text-[9px] font-bold uppercase tracking-widest text-gray-400">Due Date</p>
                                <p class="fld" data-field="due_date">{{ v(form.due_date) }}</p>
                            </div>
                        </div>

                        <template v-if="form.payment_details">
                            <p class="mt-3 mb-1 text-[9px] font-bold uppercase tracking-widest text-gray-400">Payment Details</p>
                            <p class="fld" data-field="payment_details">{{ form.payment_details }}</p>
                        </template>

                        <p class="mt-6 text-[10px] italic text-gray-400">Thank you for your business.</p>

                        <div class="mt-6">
                            <div class="w-28 border-b border-gray-400"></div>
                            <p class="mt-0.5 text-[10px] text-gray-500">{{ v(form.contractor_name, '') }}</p>
                        </div>
                    </template>

                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.doc-page p {
    margin: 2px 0;
}
.doc-page ul {
    margin: 2px 0;
}
.fld {
    color: rgb(79 70 229);
    cursor: pointer;
    border-radius: 2px;
    transition: background-color 0.15s, color 0.15s;
}
.fld:hover {
    background-color: rgb(238 242 255);
    color: rgb(55 48 163);
    text-decoration: underline;
}
</style>
