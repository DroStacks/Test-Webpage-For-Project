<div class="chatbot">

    <button
        type="button"
        class="chatbot-toggle"
        id="chatbotToggle"
        aria-label="Open HealthBridge Assistant"
    >
        💬
    </button>


    <div
        class="chatbot-window"
        id="chatbotWindow"
        hidden
    >

        <div class="chatbot-header">

            <div>
                <h3>HealthBridge Assistant</h3>
                <p>Website support assistant</p>
            </div>

            <button
                type="button"
                class="chatbot-close"
                id="chatbotClose"
                aria-label="Close HealthBridge Assistant"
            >
                ×
            </button>

        </div>


        <div
            class="chatbot-messages"
            id="chatbotMessages"
        >

            <div class="chatbot-message chatbot-message-assistant">
                Hi! I’m the HealthBridge Assistant. I can help with
                services, memberships, appointments, and navigating
                this mock website.
            </div>

        </div>


        <form
            class="chatbot-form"
            id="chatbotForm"
        >

            <input
                type="text"
                id="chatbotInput"
                name="message"
                placeholder="Ask HealthBridge a question..."
                maxlength="1000"
                autocomplete="off"
                required
            >

            <button
                type="submit"
                class="chatbot-send"
            >
                Send
            </button>

        </form>

    </div>

</div>
