<style>
    /* Loại bỏ khoảng trống dư thừa của typography plugin trong chat bubble */
    .chat-prose p:first-child { margin-top: 0; }
    .chat-prose p:last-child { margin-bottom: 0; }
</style>

<div x-data="chatWidget()" class="fixed bottom-6 left-6 z-50 flex flex-col items-start gap-3">
    <div x-show="chatOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-700 w-80 sm:w-96 flex flex-col overflow-hidden"
         style="height: 500px; max-height: calc(100vh - 120px); display: none;">

         <div class="bg-brand text-white px-4 py-3 flex justify-between items-center z-10 shadow-sm">
             <div class="flex items-center gap-2">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                 <h3 class="font-bold">Trợ lý Cờ tướng</h3>
             </div>
             <button @click="chatOpen = false" class="text-white hover:text-slate-200 focus:outline-none transition-colors">
                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
             </button>
         </div>

         <div class="flex-1 p-4 overflow-y-auto flex flex-col gap-4 bg-slate-50 dark:bg-slate-900" id="chat-messages">
             <template x-for="msg in messages" :key="msg.id">
                 <div class="flex w-full" :class="msg.role === 'user' ? 'justify-end' : 'justify-start'">
                     <div class="flex items-end gap-2 max-w-[90%]" :class="msg.role === 'user' ? 'flex-row-reverse' : 'flex-row'">

                         <div class="flex-shrink-0 h-8 w-8 rounded-full flex items-center justify-center shadow-sm"
                              :class="msg.role === 'user' ? 'bg-slate-200 dark:bg-slate-700 text-slate-500 dark:text-slate-300' : 'bg-brand/10 text-brand'">
                             <svg x-show="msg.role === 'user'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                             <svg x-show="msg.role === 'ai'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                         </div>

                         <div :class="msg.role === 'user' ? 'bg-brand text-white rounded-br-none' : 'bg-white dark:bg-slate-700 border border-slate-100 dark:border-slate-600 text-slate-800 dark:text-slate-200 shadow-sm rounded-bl-none'"
                              class="px-4 py-2 rounded-2xl text-sm leading-relaxed overflow-hidden">

                             <div x-show="msg.role === 'user'" x-text="msg.content" class="whitespace-pre-wrap"></div>

                             <div x-show="msg.role === 'ai'" x-html="msg.content" class="prose prose-sm dark:prose-invert max-w-none chat-prose"></div>
                         </div>
                     </div>
                 </div>
             </template>

             <div x-show="isLoading" class="flex w-full justify-start" style="display: none;">
                 <div class="flex items-end gap-2 max-w-[90%] flex-row">
                     <div class="flex-shrink-0 h-8 w-8 rounded-full bg-brand/10 text-brand flex items-center justify-center shadow-sm">
                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                     </div>
                     <div class="bg-white dark:bg-slate-700 border border-slate-100 dark:border-slate-600 text-slate-800 dark:text-slate-200 shadow-sm px-4 py-2 rounded-2xl rounded-bl-none text-sm flex items-center gap-2">
                         <svg class="animate-spin h-4 w-4 text-brand" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                         </svg>
                         AI đang nghĩ...
                     </div>
                 </div>
             </div>
         </div>

         <div class="p-3 bg-white dark:bg-slate-800 z-10 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] dark:shadow-none border-t border-slate-100 dark:border-slate-700">
             <form @submit.prevent="sendMessage" class="flex gap-2 relative">
                 <input type="text" x-model="newMessage" placeholder="Hỏi tôi bất cứ điều gì..."
                        class="w-full bg-slate-100 dark:bg-slate-700 border-transparent rounded-full pl-4 pr-12 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand dark:text-white"
                        :disabled="isLoading">
                 <button type="submit" class="absolute right-1 top-1 bottom-1 bg-brand hover:bg-brand-hover text-white p-1.5 w-8 rounded-full transition flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed"
                         :disabled="isLoading || !newMessage.trim()">
                     <svg class="w-4 h-4 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                 </button>
             </form>
         </div>
    </div>

    <button @click="chatOpen = !chatOpen"
            class="h-14 w-14 rounded-full bg-brand text-white shadow-lg shadow-brand/40 hover:bg-brand-hover flex items-center justify-center transition-transform hover:scale-105">
        <svg x-show="!chatOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
        <svg x-show="chatOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
</div>

<script>
    function chatWidget() {
        // Lưu trữ tin nhắn mặc định ban đầu
        const defaultMessages = [
            { id: 1, role: 'ai', content: '<p>Xin chào! Tôi là <strong>Trợ lý Cờ tướng</strong>. Bạn muốn hỏi gì về các bài viết trên blog của chúng tôi?</p>' }
        ];

        return {
            chatOpen: false,
            messages: JSON.parse(JSON.stringify(defaultMessages)),
            newMessage: '',
            isLoading: false,

            // Khởi tạo và theo dõi trạng thái đóng/mở chat
            init() {
                this.$watch('chatOpen', (isOpen) => {
                    if (!isOpen) {
                        // Đợi 200ms để hiệu ứng đóng (transition) hoàn tất trước khi xóa dữ liệu
                        setTimeout(() => {
                            this.messages = JSON.parse(JSON.stringify(defaultMessages));
                            this.newMessage = '';
                            this.isLoading = false;
                        }, 200);
                    }
                });
            },

            async sendMessage() {
                if (!this.newMessage.trim()) return;

                const userMsg = this.newMessage;
                this.messages.push({ id: Date.now(), role: 'user', content: userMsg });
                this.newMessage = '';
                this.isLoading = true;

                this.scrollToBottom();

                try {
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const response = await fetch('/chat', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({ message: userMsg })
                    });

                    const data = await response.json();

                    if (response.ok) {
                        this.messages.push({ id: Date.now(), role: 'ai', content: data.reply });
                    } else {
                        this.messages.push({ id: Date.now(), role: 'ai', content: '<p class="text-red-500">Lỗi: ' + (data.error || 'Có lỗi xảy ra!') + '</p>' });
                    }
                } catch (error) {
                    this.messages.push({ id: Date.now(), role: 'ai', content: '<p class="text-red-500">Không thể kết nối đến máy chủ.</p>' });
                } finally {
                    this.isLoading = false;
                    this.scrollToBottom();
                }
            },

            scrollToBottom() {
                setTimeout(() => {
                    const box = document.getElementById('chat-messages');
                    if (box) box.scrollTop = box.scrollHeight;
                }, 100);
            }
        }
    }
</script>
