param(
    [string]$Queues = 'high,default,low',
    [int]$SleepSeconds = 60,
    [int]$MaxJobs = 100,
    [int]$MaxRestarts = 10,
    [int]$RestartDelaySeconds = 5
)

$projectDir = Split-Path -Parent (Split-Path -Parent $PSScriptRoot)
$logDir = Join-Path $projectDir "storage\logs"
$logFile = Join-Path $logDir "queue-worker.log"
$pidFile = Join-Path $logDir "worker.pid"

if (-not (Test-Path $logDir)) {
    New-Item -ItemType Directory -Path $logDir -Force | Out-Null
}

# Guardar PID
$PID.ToString() | Out-File -FilePath $pidFile -Force

$restartCount = 0

function Start-Worker {
    param([string]$ProjectDir, [string]$Queues, [int]$MaxJobs)

    $date = Get-Date -Format "yyyy-MM-dd HH:mm:ss"

    # Verificar que PHP y artisan están disponibles
    if (-not (Get-Command php -ErrorAction SilentlyContinue)) {
        throw "PHP no encontrado en PATH"
    }

    if (-not (Test-Path (Join-Path $ProjectDir "artisan"))) {
        throw "artisan no encontrado en $ProjectDir"
    }

    & php "$ProjectDir\artisan" queue:work database `
        --queue=$Queues `
        --max-jobs=$MaxJobs `
        --max-time=3600 `
        --sleep=3 `
        --tries=3 `
        --backoff=60 `
        2>&1 | ForEach-Object {
            $date = Get-Date -Format "yyyy-MM-dd HH:mm:ss"
            "$date $_" | Out-File -FilePath $logFile -Append
            Write-Host "$date $_"
        }
}

$date = Get-Date -Format "yyyy-MM-dd HH:mm:ss"
"[$date] [INICIO] Worker de colas iniciado (colas: $Queues, max reinicios: $MaxRestarts)" | Out-File -FilePath $logFile -Append
Write-Host "[$date] [INICIO] Worker de colas iniciado - PID: $PID"

while ($restartCount -lt $MaxRestarts) {
    try {
        $date = Get-Date -Format "yyyy-MM-dd HH:mm:ss"
        "[$date] [INFO] Iniciando worker (restart #$restartCount)" | Out-File -FilePath $logFile -Append

        Start-Worker -ProjectDir $projectDir -Queues $Queues -MaxJobs $MaxJobs
    }
    catch {
        $restartCount++
        $date = Get-Date -Format "yyyy-MM-dd HH:mm:ss"
        "[$date] [ERROR] Reinicio #$restartCount/$MaxRestarts: $_" | Out-File -FilePath $logFile -Append
        Write-Host "[$date] [ERROR] Worker caido. Reintentando en ${RestartDelaySeconds}s... ($restartCount/$MaxRestarts)"
        Start-Sleep -Seconds $RestartDelaySeconds
    }
}

$date = Get-Date -Format "yyyy-MM-dd HH:mm:ss"
"[$date] [CRITICO] Worker detenido tras $MaxRestarts reinicios fallidos" | Out-File -FilePath $logFile -Append
Write-Host "[$date] [CRITICO] Worker detenido tras $MaxRestarts reinicios fallidos"
exit 1
