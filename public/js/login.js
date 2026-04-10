/**
 * Login Portal Interactions
 */
document.addEventListener('DOMContentLoaded', function() {
    // Password Visibility Toggle
    const passwordInput = document.querySelector('input[name="password"]');
    if (passwordInput) {
        const wrapper = passwordInput.parentElement;
        const toggleBtn = document.createElement('button');
        toggleBtn.type = 'button';
        toggleBtn.className = 'password-toggle';
        toggleBtn.innerHTML = '<i class="fas fa-eye"></i>';
        toggleBtn.style.cssText = `
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #8fa38f;
            cursor: pointer;
            padding: 8px;
            font-size: 16px;
            transition: all 0.3s;
            z-index: 10;
        `;
        
        wrapper.style.position = 'relative';
        wrapper.style.display = 'block';
        wrapper.appendChild(toggleBtn);

        toggleBtn.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
            this.style.color = type === 'password' ? '#8fa38f' : 'var(--primary)';
        });
    }

    // Hint Icon Tooltip (Better Implementation)
    const hintIcons = document.querySelectorAll('.hint-icon, label .hint-icon');
    
    // Remove default CSS tooltips
    hintIcons.forEach(icon => {
        // Get the hint text
        const hintText = icon.getAttribute('data-hint');
        if (!hintText) return;
        
        // Make icon clickable
        icon.style.cursor = 'pointer';
        icon.style.display = 'inline-flex';
        icon.style.alignItems = 'center';
        icon.style.justifyContent = 'center';
        icon.style.width = '16px';
        icon.style.height = '16px';
        icon.style.borderRadius = '50%';
        icon.style.background = 'linear-gradient(135deg, #e2e8f0, #cbd5e1)';
        icon.style.color = '#64748b';
        icon.style.fontSize = '9px';
        icon.style.flexShrink = '0';
        
        // Create tooltip element
        const tooltip = document.createElement('div');
        tooltip.className = 'custom-tooltip';
        tooltip.textContent = hintText;
        tooltip.style.cssText = `
            position: fixed;
            background: #0f172a;
            color: #f1f5f9;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 500;
            line-height: 1.4;
            min-width: 180px;
            max-width: 260px;
            width: max-content;
            z-index: 99999;
            box-shadow: 0 10px 40px rgba(0,0,0,0.4);
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s ease;
            pointer-events: none;
        `;
        document.body.appendChild(tooltip);
        
        // Show tooltip on click
        icon.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Get icon position
            const rect = icon.getBoundingClientRect();
            const tooltipWidth = tooltip.offsetWidth;
            
            // Position below icon
            tooltip.style.left = (rect.left + rect.width / 2 - tooltipWidth / 2) + 'px';
            tooltip.style.top = (rect.bottom + 10) + 'px';
            
            // Show
            tooltip.style.opacity = '1';
            tooltip.style.visibility = 'visible';
            
            // Close others
            document.querySelectorAll('.custom-tooltip').forEach(t => {
                if (t !== tooltip) {
                    t.style.opacity = '0';
                    t.style.visibility = 'hidden';
                }
            });
        });
    });

    // Close tooltips when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.hint-icon') && !e.target.closest('label .hint-icon')) {
            document.querySelectorAll('.custom-tooltip').forEach(tooltip => {
                tooltip.style.opacity = '0';
                tooltip.style.visibility = 'hidden';
            });
        }
    });

    // Role Card Staggered Animation
    const cards = document.querySelectorAll('.role-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'all 0.5s cubic-bezier(0.16, 1, 0.3, 1)';
        
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 400 + (index * 100));
    });
});
