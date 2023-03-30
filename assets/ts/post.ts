(() => {
    const post = document.querySelector('.post-content');
    const button = document.querySelector('.post-speak');

    if (!post || !button) {
        return;
    }

    const treeWalker = document.createTreeWalker(post, NodeFilter.SHOW_TEXT, null);
    let text = "";

    while (treeWalker.nextNode()) {
        let textNode = treeWalker.currentNode.textContent?.trim();

        if (textNode) {
            text += textNode + " ";
        }
    }

    const utterance = new SpeechSynthesisUtterance();
    utterance.text = text;
    utterance.voice = speechSynthesis.getVoices()[0];

    speechSynthesis.cancel();
    speechSynthesis.resume();

    const changeButtonContent = (iconClass: string, text: string) => {
        const icon = document.createElement('i');
        icon.classList.add('bi', iconClass);

        button.replaceChildren(
            icon,
            document.createTextNode(text)
        );
    }

    utterance.onend = () => {
        changeButtonContent('bi-play-fill', 'Listen');

        speechSynthesis.cancel();
    }

    button.addEventListener('click', () => {
        if (speechSynthesis.speaking && !speechSynthesis.paused) {
            changeButtonContent('bi-play-fill', 'Resume');

            speechSynthesis.pause();
        } else {
            changeButtonContent('bi-pause-fill', 'Pause');

            if (speechSynthesis.paused) {
                speechSynthesis.resume();
            } else {
                speechSynthesis.speak(utterance);
            }
        }
    });
})();
