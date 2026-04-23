#!/bin/bash

# Security Check Script - Bolsa de Proyectos SENA
# Verifica que no haya credenciales expuestas en el repositorio

RED='\033[0;31m'
YELLOW='\033[1;33m'
GREEN='\033[0;32m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo -e "${BLUE}========================================${NC}"
echo -e "${BLUE}🔒 SECURITY CHECK - BOLSA DE PROYECTOS${NC}"
echo -e "${BLUE}========================================${NC}\n"

ISSUES_FOUND=0

# 1. Verificar que .env no está en git
echo -e "${BLUE}[1/5]${NC} Verificando que .env no está en git..."
if git ls-files | grep -q "^\.env$"; then
    echo -e "${RED}❌ .env está siendo tracked por git!${NC}"
    ISSUES_FOUND=$((ISSUES_FOUND + 1))
else
    echo -e "${GREEN}✓ .env no está en git${NC}"
fi

# 2. Verificar credenciales en código
echo -e "\n${BLUE}[2/5]${NC} Buscando credenciales expostas en el código..."
CREDS_FOUND=0

# Buscar contraseñas hardcodeadas
if grep -r "password\s*=\s*['\"]" --include="*.php" --include="*.js" app/ routes/ config/ 2>/dev/null | grep -v "hash\|bcrypt\|password_field\|password_confirmation"; then
    echo -e "${YELLOW}⚠️  Posibles contraseñas hardcodeadas encontradas${NC}"
    CREDS_FOUND=$((CREDS_FOUND + 1))
fi

# Buscar API keys
if grep -r "api[_-]?key\s*=\s*['\"]" --include="*.php" app/ 2>/dev/null; then
    echo -e "${YELLOW}⚠️  Posibles API keys encontradas${NC}"
    CREDS_FOUND=$((CREDS_FOUND + 1))
fi

if [ $CREDS_FOUND -eq 0 ]; then
    echo -e "${GREEN}✓ No se encontraron credenciales expostas${NC}"
else
    ISSUES_FOUND=$((ISSUES_FOUND + 1))
fi

# 3. Verificar Content-Security-Policy
echo -e "\n${BLUE}[3/5]${NC} Verificando Content-Security-Policy..."
# Buscar unsafe-eval que NO esté en comentarios
if grep "unsafe-eval" app/Http/Middleware/SecurityHeadersMiddleware.php | grep -v "^[[:space:]]*//"; then
    echo -e "${RED}❌ CSP contiene 'unsafe-eval'${NC}"
    ISSUES_FOUND=$((ISSUES_FOUND + 1))
else
    echo -e "${GREEN}✓ CSP no contiene 'unsafe-eval'${NC}"
fi

# 4. Verificar XSS en notificaciones
echo -e "\n${BLUE}[4/5]${NC} Verificando XSS en notificaciones..."
if grep -q '{!! .*mensaje' resources/views/shared/notificaciones.blade.php 2>/dev/null; then
    echo -e "${RED}❌ XSS encontrado en notificaciones.blade.php${NC}"
    ISSUES_FOUND=$((ISSUES_FOUND + 1))
else
    echo -e "${GREEN}✓ Notificaciones están escapadas correctamente${NC}"
fi

# 5. Verificar .gitignore
echo -e "\n${BLUE}[5/5]${NC} Verificando .gitignore..."
if grep -q "^\.env$" .gitignore; then
    echo -e "${GREEN}✓ .env está en .gitignore${NC}"
else
    echo -e "${RED}❌ .env NO está en .gitignore${NC}"
    ISSUES_FOUND=$((ISSUES_FOUND + 1))
fi

# Resumen
echo -e "\n${BLUE}========================================${NC}"
if [ $ISSUES_FOUND -eq 0 ]; then
    echo -e "${GREEN}✅ TODAS LAS VERIFICACIONES PASARON${NC}"
    echo -e "${GREEN}El repositorio es seguro.${NC}"
else
    echo -e "${RED}❌ $ISSUES_FOUND PROBLEMAS ENCONTRADOS${NC}"
    echo -e "${RED}Revisa los items marcados arriba.${NC}"
fi
echo -e "${BLUE}========================================${NC}\n"

exit $ISSUES_FOUND
