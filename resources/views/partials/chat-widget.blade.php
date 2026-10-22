<div x-data="chatWidget()" class="fixed bottom-5 right-5 z-50">
    <button @click="open = !open" class="flex h-14 w-14 items-center justify-center rounded-full bg-brand-blue-deep text-white shadow-lg hover:bg-navy transition">
        <svg x-show="!open" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
        <svg x-show="open" x-cloak class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
    </button>

    <div x-show="open" x-cloak x-transition @click.outside="open = false"
         class="absolute bottom-16 right-0 w-80 sm:w-96 rounded-2xl bg-white border border-line shadow-2xl flex flex-col overflow-hidden" style="height:28rem;">
        <div class="bg-navy text-white px-4 py-3 font-semibold text-sm">Ask {{ $siteCompany['name'] }}</div>
        <div class="flex-1 overflow-y-auto px-4 py-3 space-y-3 text-sm" x-ref="log">
            <template x-for="(m, i) in messages" :key="i">
                <div :class="m.from === 'user' ? 'text-right' : 'text-left'">
                    <span :class="m.from === 'user' ? 'bg-brand-blue-deep text-white' : 'bg-surface text-navy'" class="inline-block rounded-xl px-3 py-2 max-w-[85%] whitespace-pre-line text-left">{{ "" }}<span x-text="m.text"></span></span>
                </div>
            </template>
            <div x-show="loading" class="text-xs text-slate-ink">Thinking…</div>
        </div>
        <form @submit.prevent="send" class="border-t border-line p-3 flex gap-2">
            <input x-model="input" type="text" placeholder="Ask about jobs or services…" class="flex-1 rounded-full border border-line-strong px-3 py-2 text-sm">
            <button class="rounded-full bg-brand-blue-deep text-white px-4 py-2 text-sm font-semibold">Send</button>
        </form>
    </div>
</div>

<script>
    function chatWidget() {
        return {
            open: false,
            loading: false,
            input: '',
            messages: [{ from: 'bot', text: @js($siteChatWelcome ?: 'Hi! Ask me about our open jobs or services.') }],
            send() {
                const text = this.input.trim();
                if (!text) return;
                this.messages.push({ from: 'user', text });
                this.input = '';
                this.loading = true;
                fetch('{{ route('chat.reply') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ message: text }),
                })
                    .then(r => r.json())
                    .then(data => {
                        this.messages.push({ from: 'bot', text: data.reply ?? 'Sorry, something went wrong.' });
                    })
                    .catch(() => {
                        this.messages.push({ from: 'bot', text: 'Sorry, something went wrong. Please try the contact form.' });
                    })
                    .finally(() => {
                        this.loading = false;
                        this.$nextTick(() => { this.$refs.log.scrollTop = this.$refs.log.scrollHeight; });
                    });
            },
        };
    }
</script>
